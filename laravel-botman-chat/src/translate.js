// src/utils/translate.js
import axios from 'axios';

const API_URL = 'https://libretranslate.de'; // or your self-hosted instance

export async function detectLanguage(text) {
  try {
    const res = await axios.post(`${API_URL}/detect`, { q: text });
    return res.data[0]?.language || 'en';
  } catch {
    return 'en';
  }
}

export async function translateText(text, target, source = 'en') {
  try {
    const res = await axios.post(`${API_URL}/translate`, {
      q: text,
      source,
      target,
      format: 'text'
    });
    return res.data.translatedText;
  } catch {
    return text;
  }
}
