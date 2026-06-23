function mapObject(obj, callback) {
    let result = {};
    for (let key in obj) {
        let value = obj[key];
        let newValue = callback(value);
        result[key] = newValue;
    }
    return result;
}

const nums = { a: 10, b: 2, c: 3 };
console.log(mapObject(nums, x => x * 2));
