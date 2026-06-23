function countVowels(str) {
    const vowels = 'аеёиоуыэюяАЕЁИОУЫЭЮЯ';
    let count = 0;
    for (let i = 0; i < str.length; i++) {
        for (let j = 0; j < vowels.length; j++) {
            if (str[i] === vowels[j]) {
                count++;
                break;
            }
        }
    }
    return count + ' гласных';
}

console.log(countVowels("Подсчёт гласных в строке"));