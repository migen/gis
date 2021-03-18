const express = require('express');
const app = express();


app.post('/',(req,res) => {
	res.send('home express');
});

app.post('/users',(req,res) => {
	res.send('users page express');
});


app.listen(3000);
