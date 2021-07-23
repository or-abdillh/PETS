const Modal = {
  parent: document.querySelector('.modal'),
  img: document.querySelector('.modal .modal-body img'),
  download: document.querySelector('[data-role=download]'),
  share: document.querySelector('[data-role=share]')
}

document.addEventListener('click', function(el) {
  let element = el.target;
  let role = element.dataset.role;
  let urlImg;
  
  //Triger button
  if (role == 'triger') {
    
    //Get informasi img yang di klik
    urlImg = element.dataset.url;
    
    //Generate info to modal
    Modal.img.setAttribute('src', urlImg);
    
    setTimeout(function() {
      Modal.parent.classList.toggle('modal-show');
    }, 400);
  }
  
  //Download modal button
  if (role == 'download') {
    
    setTimeout(function() {
      changeHref(Modal.img.getAttribute('src'));
    }, 400);
  }
  
  //Share modal button
  if (role == 'share') {
    if (navigator.share) {
      navigator.share({
        title: 'Random Pets Image',
        url: Modal.img.getAttribute('src')
      }).then(result => {
        console.log(result)
      }).catch(err => {
        console.error(err)
      })
    }
  }
  
  //Close modal button
  if (role == 'close') {
    setTimeout(function() {
      Modal.parent.classList.toggle('modal-show');
    }, 400);
  }
})

const changeHref = url => {
  window.location.href = url;
}