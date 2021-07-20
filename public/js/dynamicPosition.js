const category = document.querySelector('.categorys');
const header = document.querySelector('.container .header');
const items = document.querySelectorAll('.categorys .item');
const circles = document.querySelectorAll('.categorys .fa-circle');

// Add class active jika item di klik
items.forEach((item, index) => {
  item.addEventListener('click', function() {
  
    for (const item of items) {
      item.classList.remove('active');
    }
    
    for (const circle of circles) {
      circle.classList.remove('circle-active');
    }
    
    item.classList.add('active');
    
    //Circle add class circle-active
    circles[index].classList.add('circle-active');
  })
})

//Dynamic Theme Color
const themeColor = document.querySelector('[name=theme-color]');

const changeThemeColor = function() {
  let colorCategory = getComputedStyle(category).backgroundColor;
  
  themeColor.setAttribute('content', colorCategory);
}

//Dynamic Position
window.addEventListener('scroll', function() {
  
  let Header = {
    top : Math.round(header.getBoundingClientRect().top),
    height : Math.round(header.getBoundingClientRect().height)
  }
  
  let heightCategory = Math.round(category.getBoundingClientRect().height);
  let HeaderBottom = -Math.abs(Header.height - heightCategory);
  
  let headerClass = header.classList;
  let categoryClass = category.classList;
 
  if ( Header.top <= HeaderBottom ) {
    category.classList.add('fixed');
    changeThemeColor();
  } else {
    category.classList.remove('fixed');
    changeThemeColor();
  }
})