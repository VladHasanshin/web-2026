function mergeObjects(obj1, obj2) {
    let result = {};
    for (let key in obj1) {
        result[key] = obj1[key];
    }
    for (let key in obj2) {
        result[key] = obj2[key];
    }
    return result;
}

console.log(mergeObjects({ a: 1, b: 2 }, { b: 3, c: 4 }));