function firstSymbolCreate(string) {
    result = string[Math.floor(Math.random() * string.length)];
    return result;
}

function generatePassword(length) {
    if (length < 4) {
        return 'Ошибка: длина должна быть не меньше 4';
    }
    const lowLetters = 'abcdefghijklmnopqrstuvwxyz';
    const upLetters = 'BCDEFGHIJKLMNOPQRSTUVWXYZ';
    const numbers = '1234567890';
    const symbols = '!@#$%^&*()_+[]{}|;:,.<>?';
    const chars = lowLetters + upLetters + numbers + symbols;

    let password = '';
    password += firstSymbolCreate(lowLetters);
    password += firstSymbolCreate(upLetters);
    password += firstSymbolCreate(numbers);
    password += firstSymbolCreate(symbols);

    for (let i = 4; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * chars.length);
        password += chars[randomIndex];
    }
    return password;
}

console.log(generatePassword(4));