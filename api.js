const express = require('express');
const axios = require('axios');
const app = express();

const apiKey = 'API_KULCSOD'; // Cseréld le az API kulcsra

app.use(express.json());

app.post('/generate-plan', async (req, res) => {
  const userInput = req.body.input; // Pl. edzés és táplálkozási célok
  
  try {
    const response = await axios.post('https://api.openai.com/v1/completions', {
      model: 'text-davinci-003', 
      prompt: `Személyre szabott edzésterv és étkezési ajánlások: ${userInput}`,
      max_tokens: 150,
    }, {
      headers: {
        'Authorization': `Bearer ${apiKey}`,
        'Content-Type': 'application/json',
      }
    });
    
    res.json(response.data.choices[0].text);
  } catch (error) {
    res.status(500).send('AI szolgáltatás hiba');
  }
});

app.listen(3000, () => {
  console.log('Server running on http://localhost:3000');
});
