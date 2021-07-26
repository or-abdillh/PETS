const boxContent = document.querySelector('.content');

//Template item

function makeElement(url, category, parent) {
  
  //Create element
  let item = document.createElement('div');
  let img = document.createElement('img');
  let layer = document.createElement('div');
  let anchor = document.createElement('a');
  
  //Set class and atribute
  item.classList.add('item');
  img.setAttribute('src', url);
  img.setAttribute('alt', category);
  layer.classList.add('layer');
  anchor.setAttribute('data-role', 'triger');
  anchor.setAttribute('data-url', url);
  
  //Append
  item.appendChild(img);
  item.appendChild(layer);
  layer.appendChild(anchor);
  anchor.innerHTML = 'Click to view';
  
  //Append to parent
  parent.appendChild(item);
}

//Request data
function renderData(str = "") {
  
  fetch('./public/assets/json/' + str + '.json')
    .then(async res => {
      try {
        let response = await res.json();
        
        let category = response.category;
        response = response.results;
        
        //Render element
        response.forEach(item => {
          makeElement(item.url, category, boxContent);
        });
        
      } catch (err) {
        console.log(err)
      }
    });
}

//Menu category apa yang aktif
function checkActiveMenu() {
  
  const menuCategorys = document.querySelectorAll('[data-role=menu]');
  for (const menu of menuCategorys) {
    if (menu.classList.contains('active')) return menu.dataset.index;
  }
}

//Render content saat pertama kali di load
window.addEventListener('load', () => {
  
  //Render data 
  renderData(checkActiveMenu());
})

//Render category sesuai menu active
let categorys = document.querySelectorAll('.item');

for (const item of categorys ) {
  
  item.addEventListener('click', function() {
    
    let index = this.dataset.index;
    
    boxContent.innerHTML = '';
    renderData(index)
  })
}

