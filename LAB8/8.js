const numbers = [2, 5, 8, 10, 3];

const tripledNumbers = numbers.map(n => n * 3);
const filteredNumbers = tripledNumbers.filter(n => n > 10);

console.log(filteredNumbers);