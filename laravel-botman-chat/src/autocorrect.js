const input = document.getElementById("inputText");
const correctionBox = document.getElementById("correction");

const dictionary = new Typo("en_US", false, false, {
  dictionaryPath: "./dictionaries"
});

input.addEventListener("input", () => {
  const text = input.value.trim();
  const words = text.split(" ");
  const suggestions = [];

  words.forEach(word => {
    if (!dictionary.check(word)) {
      const suggestion = dictionary.suggest(word)[0];
      if (suggestion) suggestions.push(suggestion);
      else suggestions.push(word);
    } else {
      suggestions.push(word);
    }
  });

  const correctedText = suggestions.join(" ");
  correctionBox.textContent = correctedText !== text ? `Suggestion: ${correctedText}` : "";
});
