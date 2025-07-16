import React, { useState, useEffect, useRef } from 'react';
import axios from 'axios';
import Typo from 'typo-js';
import './App.css';

// 🔁 Synonym Expansion Function (OUTSIDE the Chatbot component)
const getSynonymExpandedQuery = async (text) => {
  const words = text.split(' ');
  let allWords = new Set(words);

  for (let word of words) {
    if (/^[a-zA-Z]+$/.test(word)) {
      try {
        const response = await axios.get(`https://api.datamuse.com/words?rel_syn=${word}`);
        response.data.slice(0, 3).forEach(item => allWords.add(item.word));
      } catch (error) {
        console.error(`Failed to fetch synonyms for "${word}":`, error);
      }
    }
  }

  return Array.from(allWords).join(' ');
};

function Chatbot() {
  const [messages, setMessages] = useState([]);
  const [userInput, setUserInput] = useState('');
  const [visible, setVisible] = useState(false);
  const [suggestions, setSuggestions] = useState([]);
  const [showWelcomePopup, setShowWelcomePopup] = useState(true);
  const [isTyping, setIsTyping] = useState(false);
  const [unreadCount, setUnreadCount] = useState(0);
  const [isMinimized, setIsMinimized] = useState(false);
  const [typingTimeout, setTypingTimeout] = useState(null);
  const [correction, setCorrection] = useState(null);
  const [language, setLanguage] = useState(null); // 'en' or 'sw'
  const messagesEndRef = useRef(null);
  const dictionary = useRef(null);

  // Language-specific content
  const content = {
    en: {
      welcomeMessage: "👋 Hi there! I'm your virtual assistant. How can I help you today?",
      welcomePopup: "👋 Click to chat with us!",
      quickOptions: ['Reset Password', 'Check Order Status', 'Payment Options', 'Contact Support', 'Account Settings', 'FAQ'],
      placeholder: "Type your message...",
      emptyState: "How can I assist you today?",
      typingStatus: "Typing",
      onlineStatus: "Online",
      correctionText: "Did you mean: ",
      systemError: "⚠️ Our systems are currently unavailable. Please try again later or contact support@example.com",
      defaultReply: "🤖 Sorry, I didn't quite understand that. Could you rephrase or try asking differently?"
    },
    sw: {
      welcomeMessage: "👋 Hujambo! Mimi ni msaidizi wako wa kivitendo. Nikuweze kusaidiaje leo?",
      welcomePopup: "👋 Bonyeza kuongea nasi!",
      quickOptions: ['Weka Nenosiri Upya', 'Angalia Hali ya Agizo', 'Chaguzi za Malipo', 'Wasiliana na Usaidizi', 'Mipangilio ya Akaunti', 'Maswali Yanayoulizwa Mara kwa Mara'],
      placeholder: "Andika ujumbe wako...",
      emptyState: "Naweza kukusaidiaje leo?",
      typingStatus: "Inachapa",
      onlineStatus: "Mtandaoni",
      correctionText: "Ulimaanisha: ",
      systemError: "⚠️ Mifumo yetu kwa sasa haipatikani. Tafadhali jaribu tena baadaye au wasiliana na support@example.com",
      defaultReply: "🤖 Samahani, sikuweza kufahamu hilo. Unaweza kusema kwa njia nyingine au kuuliza kwa njia tofauti?"
    }
  };

  // ✅ Load Typo.js Dictionary from public/dictionaries
  
  // ✅ Autoscroll
  const scrollToBottom = () => {
    messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
  };
  useEffect(() => {
    scrollToBottom();
  }, [messages]);

  // ✅ Hide welcome after 5 seconds
  useEffect(() => {
    const timer = setTimeout(() => {
      setShowWelcomePopup(false);
    }, 5000);
    return () => clearTimeout(timer);
  }, []);

  // ✅ Track unread messages
  useEffect(() => {
    if (!visible && messages.length > 0) {
      const lastMessage = messages[messages.length - 1];
      if (lastMessage.from === 'bot') {
        setUnreadCount(prev => prev + 1);
      }
    }
  }, [messages, visible]);

  // ✅ First bot message
  useEffect(() => {
    if (visible && messages.length === 0 && language) {
      setTimeout(() => {
        setMessages(prev => [...prev, {
          from: 'bot',
          text: content[language].welcomeMessage,
          timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        }]);
        setUnreadCount(0);
      }, 300);
    }
  }, [visible, language]);

  // ✅ Autocomplete + Autocorrect + Synonym Expansion
  useEffect(() => {
    if (typingTimeout) clearTimeout(typingTimeout);

    const timer = setTimeout(() => {
      const fetchSuggestions = async () => {
        const input = userInput.trim();
        if (input.length < 2) {
          setSuggestions([]);
          return;
        }

        try {
          // 🔁 Send full input to Laravel (let Laravel autocorrect + match)
          const response = await axios.get(
            `http://localhost:8000/autocomplete?query=${encodeURIComponent(input)}`
          );

          const results = response.data.map(item => item.question || item);
          setSuggestions(results.slice(0, 5));

        } catch (err) {
          console.error('Suggestion fetch failed:', err);
          setSuggestions([]);
        }
      };

      fetchSuggestions();
    }, 300);

    setTypingTimeout(timer);
    return () => clearTimeout(timer);
  }, [userInput]);

  const handleInputChange = (e) => {
    const input = e.target.value;
    setUserInput(input);
    if (correction && input === correction.original) return;
    if (correction && input !== correction.corrected) {
      setCorrection(null);
    }
  };

  const sendMessage = async (text = userInput) => {
    if (text.trim() === '') return;

    // Use corrected text if available
    let finalText = correction ? correction.corrected : text;

    const userMessage = { 
      from: 'user', 
      text: finalText,
      timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    };
    setMessages(prev => [...prev, userMessage]);
    setUserInput('');
    setCorrection(null);
    setSuggestions([]);
    setIsTyping(true);

    try {
      const response = await axios.post('http://localhost:8000/botman', { message: finalText });

      setTimeout(() => {
        const botReply = response.data.messages?.[0]?.text || content[language]?.defaultReply || "🤖 Sorry, I didn't quite understand that.";
        setMessages(prev => [...prev, { 
          from: 'bot', 
          text: botReply,
          timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        }]);
        setIsTyping(false);
      }, 1000 + Math.random() * 1000);
    } catch (error) {
      setMessages(prev => [...prev, { 
        from: 'bot', 
        text: content[language]?.systemError || "⚠️ Our systems are currently unavailable.",
        timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
      }]);
      setIsTyping(false);
    }
  };

  const handleSuggestionClick = (suggestion) => {
    sendMessage(suggestion);
  };

  const acceptCorrection = () => {
    if (correction) {
      setUserInput(correction.corrected);
      setCorrection(null);
    }
  };

  const clearChat = () => {
    setMessages([]);
    setUserInput('');
    setCorrection(null);
  };

  const toggleChat = () => {
    setVisible(!visible);
    if (!visible) setUnreadCount(0);
  };

  const toggleMinimize = () => {
    setIsMinimized(!isMinimized);
  };

  const selectLanguage = (lang) => {
    setLanguage(lang);
    setVisible(true);
  };

  // Language selection modal
  if (visible && !language) {
    return (
      <div className="chatbot-wrapper visible">
        <div className="language-selection-modal">
          <h3>Chagua Lugha / Select Language</h3>
          <div className="language-options">
            <button onClick={() => selectLanguage('sw')}>
              <span role="img" aria-label="Kiswahili">🇹🇿</span> Kiswahili
            </button>
            <button onClick={() => selectLanguage('en')}>
              <span role="img" aria-label="English">🇬🇧</span> English
            </button>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className={`chatbot-wrapper ${visible ? 'visible' : ''}`}>
      <div className="chat-icon-container">
        <button className="chat-toggle" onClick={toggleChat}>
          <div className="chat-icon">
            <svg viewBox="0 0 24 24">
              <path fill="currentColor" d="M19.005 3.175H4.674C3.642 3.175 3 3.789 3 4.821V21.02l3.544-3.514h12.461c1.033 0 2.064-1.06 2.064-2.093V4.821c-.001-1.032-1.032-1.646-2.064-1.646zm-4.989 9.869H7.041V11.1h6.975v1.944zm3-4H7.041V7.1h9.975v1.944z"/>
            </svg>
          </div>
          {unreadCount > 0 && <span className="unread-badge">{unreadCount}</span>}
        </button>

        {showWelcomePopup && !visible && (
          <div className="welcome-popup">
            <span className="wave">👋</span> {language ? content[language].welcomePopup : "Click to chat with us!"}
          </div>
        )}
      </div>

      {visible && language && (
        <div className={`chatbox ${isMinimized ? 'minimized' : ''}`}>
          <div className="chat-header">
            <div className="header-content">
              <div className="bot-avatar">
                <svg viewBox="0 0 24 24">
                  <path fill="currentColor" d="M12,2A2,2 0 0,1 14,4C14,4.74 13.6,5.39 13,5.73V7H14A7,7 0 0,1 21,14H22A1,1 0 0,1 23,15V18A1,1 0 0,1 22,19H21V20A2,2 0 0,1 19,22H5A2,2 0 0,1 3,20V19H2A1,1 0 0,1 1,18V15A1,1 0 0,1 2,14H3A7,7 0 0,1 10,7H11V5.73C10.4,5.39 10,4.74 10,4A2,2 0 0,1 12,2M7.5,13A2.5,2.5 0 0,0 5,15.5A2.5,2.5 0 0,0 7.5,18A2.5,2.5 0 0,0 10,15.5A2.5,2.5 0 0,0 7.5,13M16.5,13A2.5,2.5 0 0,0 14,15.5A2.5,2.5 0 0,0 16.5,18A2.5,2.5 0 0,0 19,15.5A2.5,2.5 0 0,0 16.5,13Z"/>
                </svg>
              </div>
              <div>
                <h3>Heva Fund Virtual Assistant</h3>
                <p className="status">
                  {isTyping ? (
                    <span className="typing-status">
                      <span>{content[language].typingStatus}</span>
                      <span className="typing-dots">
                        <span>.</span>
                        <span>.</span>
                        <span>.</span>
                      </span>
                    </span>
                  ) : (
                    <span className="online-status">
                      <span className="online-dot"></span>
                      {content[language].onlineStatus}
                    </span>
                  )}
                </p>
              </div>
            </div>
            <div className="header-actions">
              <button className="minimize-btn" onClick={toggleMinimize} title={isMinimized ? 'Restore' : 'Minimize'}>
                {isMinimized ? (
                  <svg viewBox="0 0 24 24" width="16" height="16">
                    <path fill="currentColor" d="M19,13H5V11H19V13Z" />
                  </svg>
                ) : (
                  <svg viewBox="0 0 24 24" width="16" height="16">
                    <path fill="currentColor" d="M19,13H5V11H19V13Z" />
                  </svg>
                )}
              </button>
              <button className="clear-btn" onClick={clearChat} title="Clear conversation">
                <svg viewBox="0 0 24 24" width="16" height="16">
                  <path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                </svg>
              </button>
              <button className="close-btn" onClick={toggleChat} title="Close chat">
                <svg viewBox="0 0 24 24" width="16" height="16">
                  <path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
                </svg>
              </button>
            </div>
          </div>
          

          {!isMinimized && (
            <>
              <div className="chat-messages">
                {messages.length === 0 && (
                  <div className="empty-state">
                    <div className="empty-icon">
                      <svg viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12,3C6.5,3 2,6.58 2,11C2,13.13 3.05,15.07 4.75,16.5C4.7,17.1 4.33,18.67 2,21C4.37,20.89 6.64,20 8.47,18.5C9.61,18.83 10.81,19 12,19C17.5,19 22,15.42 22,11C22,6.58 17.5,3 12,3M12,17C7.58,17 4,14.31 4,11C4,7.69 7.58,5 12,5C16.42,5 20,7.69 20,11C20,14.31 16.42,17 12,17Z" />
                      </svg>
                    </div>
                    <p>{content[language].emptyState}</p>
                    <div className="quick-buttons">
                      {content[language].quickOptions.map((option, i) => (
                        <button key={i} onClick={() => sendMessage(option)}>{option}</button>
                      ))}
                    </div>
                  </div>
                )}

                {messages.map((msg, index) => (
                  <div key={index} className={`message ${msg.from}`}>
                    <div className="message-content">
                      {msg.from === 'bot' && (
                        <div className="avatar">
                          <svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12,2A2,2 0 0,1 14,4C14,4.74 13.6,5.39 13,5.73V7H14A7,7 0 0,1 21,14H22A1,1 0 0,1 23,15V18A1,1 0 0,1 22,19H21V20A2,2 0 0,1 19,22H5A2,2 0 0,1 3,20V19H2A1,1 0 0,1 1,18V15A1,1 0 0,1 2,14H3A7,7 0 0,1 10,7H11V5.73C10.4,5.39 10,4.74 10,4A2,2 0 0,1 12,2M7.5,13A2.5,2.5 0 0,0 5,15.5A2.5,2.5 0 0,0 7.5,18A2.5,2.5 0 0,0 10,15.5A2.5,2.5 0 0,0 7.5,13M16.5,13A2.5,2.5 0 0,0 14,15.5A2.5,2.5 0 0,0 16.5,18A2.5,2.5 0 0,0 19,15.5A2.5,2.5 0 0,0 16.5,13Z" />
                          </svg>
                        </div>
                      )}
                      <div className="message-bubble">
                        <div className="message-text">{msg.text}</div>
                        <div className="message-time">{msg.timestamp}</div>
                      </div>
                      {msg.from === 'user' && (
                        <div className="avatar">
                          <svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />
                          </svg>
                        </div>
                      )}
                    </div>
                  </div>
                ))}

                {isTyping && (
                  <div className="message bot">
                    <div className="message-content">
                      <div className="avatar">
                        <svg viewBox="0 0 24 24">
                          <path fill="currentColor" d="M12,2A2,2 0 0,1 14,4C14,4.74 13.6,5.39 13,5.73V7H14A7,7 0 0,1 21,14H22A1,1 0 0,1 23,15V18A1,1 0 0,1 22,19H21V20A2,2 0 0,1 19,22H5A2,2 0 0,1 3,20V19H2A1,1 0 0,1 1,18V15A1,1 0 0,1 2,14H3A7,7 0 0,1 10,7H11V5.73C10.4,5.39 10,4.74 10,4A2,2 0 0,1 12,2M7.5,13A2.5,2.5 0 0,0 5,15.5A2.5,2.5 0 0,0 7.5,18A2.5,2.5 0 0,0 10,15.5A2.5,2.5 0 0,0 7.5,13M16.5,13A2.5,2.5 0 0,0 14,15.5A2.5,2.5 0 0,0 16.5,18A2.5,2.5 0 0,0 19,15.5A2.5,2.5 0 0,0 16.5,13Z" />
                        </svg>
                      </div>
                      <div className="message-bubble">
                        <div className="typing-indicator">
                          <span></span>
                          <span></span>
                          <span></span>
                        </div>
                      </div>
                    </div>
                  </div>
                )}
                <div ref={messagesEndRef} />
              </div>

              <div className="input-section">
                {correction && (
                  <div className="correction-banner">
                    <span>{content[language].correctionText}</span>
                    <button className="correction-text" onClick={acceptCorrection}>
                      {correction.corrected}
                    </button>
                    <button className="dismiss-correction" onClick={() => setCorrection(null)}>
                      ×
                    </button>
                  </div>
                )}

                {suggestions.length > 0 && (
                  <div className="suggestions-container">
                    {suggestions.map((sug, index) => (
                      <button 
                        key={index} 
                        className="suggestion-item"
                        onClick={() => handleSuggestionClick(sug)}
                      >
                        {sug}
                      </button>
                    ))}
                  </div>
                )}

                <div className="chat-input-container">
                  <div className="chat-input">
                    <input
                      type="text"
                      placeholder={content[language].placeholder}
                      value={correction ? correction.corrected : userInput}
                      onChange={handleInputChange}
                      onKeyDown={(e) => {
                        if (e.key === 'Enter') {
                          sendMessage();
                        }
                        if (e.key === 'Escape' && correction) {
                          setUserInput(correction.original);
                          setCorrection(null);
                        }
                      }}
                      aria-label="Type your message"
                      className={correction ? 'corrected-input' : ''}
                    />
                    <button 
                      onClick={() => sendMessage()} 
                      disabled={userInput.trim() === ''}
                      aria-label="Send message"
                    >
                      <svg viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
                      </svg>
                    </button>
                  </div>
                  <div className="quick-buttons">
                    {content[language].quickOptions.slice(0, 4).map((option, i) => (
                      <button key={i} onClick={() => sendMessage(option)}>{option}</button>
                    ))}
                  </div>
                </div>
              </div>
            </>
          )}
        </div>
      )}
    </div>
  );
}

export default Chatbot;