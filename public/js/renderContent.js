const endpoint = "http://localhost:8000/PETS/server/rest/"

fetch(endpoint + '?category=cats&limit=5')
  .then( async response => {
    try {
      let data = await response.json();
      alert(JSON.stringify(data))
    } catch(err) {
      alert(err)
    }
  })