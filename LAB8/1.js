function isPrimeNumber(input) {
    if (typeof input !== 'number' && !Array.isArray(input)) {
        console.log('Ошибка: должно быть число/массив');
        return;
    }
    const numbers = Array.isArray(input) ? input : [input];
    let results = [];
    for (let num of numbers) {
        if (typeof num !== 'number') {
            results.push('не число');
            continue;
        }
        let isPrime = num > 1;
        for (let i = 2; i < num; i++) {
            if (num % i === 0) {
                isPrime = false;
                break;
            }
        }
        results.push(isPrime ? num + ' простое число' : num + ' не простое число');
    }
    console.log(results.join(", "));
}

isPrimeNumber('num');
isPrimeNumber(3);
isPrimeNumber(1);
isPrimeNumber(4);
isPrimeNumber([3, 4, 5]);
isPrimeNumber([3, 'num', 6]);
isPrimeNumber([-3, 0, 56]);