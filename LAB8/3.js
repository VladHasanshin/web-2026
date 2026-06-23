function uniqueElements(array) {
    let result = {};
    for (let item of array) {
        let key = String(item);
        result[key] ? result[key] += 1 : result[key] = 1;
    }
    return result;
}

const information = ['привет', 'hello', 1, '1', 'лаба', '2', 2];
console.log(uniqueElements(information));