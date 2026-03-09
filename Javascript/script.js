let a = 5;    
let b = 10;

console.log("Before : a =", a, "b =", b);


a = a + b;  //a is now 15 
b = a - b;   // b becomes 5
a = a - b;    //a becomes 10

console.log("After Swap: a =", a, "b =", b);







function square(n)
 {
    return n * n;
}

for (let i = 1; i <= 10; i++)
     {
    console.log("Square of", i, "=", square(i));
}




let numbers = [12, 45, 7, 89, 23];

let largest = numbers[0];

for (let i = 1; i < numbers.length; i++) {
    if (numbers[i] > largest) {
        largest = numbers[i];
    }
}

console.log("Largest number is: " + largest);




