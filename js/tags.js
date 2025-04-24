// JavaScript Document

  var todostags = [];
  function tags(valor){
    const tagContainer = document.querySelector('.tag-container');
    const input = document.querySelector('.tag-container input');
    
    var ultima = valor.substr(valor.length -1);
    if(ultima===","){
      
      valor = valor.substring(0, valor.length - 1);
      //tagContainer.prepend(createTag(valor));
      todostags.push(valor)
      addTags()
      input.value = ''; 
    }
  }
  
  //
  //console.log(tagContainer);
  
  function createTag(label){
    const div = document.createElement('div');
    div.setAttribute('class', 'tag');
    const span = document.createElement('span');
    span.innerHTML = label;
    const closeBtn = document.createElement('i');
    closeBtn.setAttribute('class', 'material-icons');
    
    closeBtn.innerHTML = 'close';

    closeBtn.setAttribute('data-item', label);
    closeBtn.setAttribute('onClick', 'cancela("'+label+'")');
    
    div.appendChild(span);
    div.appendChild(closeBtn);
    return div;
  }
  
  function clearTags() {
    document.querySelectorAll('.tag').forEach(tag => {
      tag.parentElement.removeChild(tag);
    });
  }

  function addTags() {
    const tagContainer = document.querySelector('.tag-container');
    clearTags();
    todostags.slice().reverse().forEach(tag => {
      tagContainer.prepend(createTag(tag));
    });
    document.getElementById('palabras').value=todostags.toString();

  }
  
  function cancela(tagLabel){
    const index = todostags.indexOf(tagLabel);
    todostags = [...todostags.slice(0, index), ...todostags.slice(index+1)];
    addTags();
  }