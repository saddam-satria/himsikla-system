const test = [
  {
    name: 'saddam',
  },
  {
    name: 'satria',
  },
  {
    name: 'ardhi',
  },
];
const test2 = [
  {
    name: 'saddam',
  },
  {
    name: 'satria',
  },
];

const result = test.filter((item) => test2.find((i) => i.name === item.name));

console.log(result);

console.log(test2.filter(({ name }) => name === 'ardhi'));
