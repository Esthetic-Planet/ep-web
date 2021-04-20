/**
 * Helper function to return customMade elements
 */

function newDOMElement(tag, classes = '', str = ''){

  let el = document.createElement(tag);

  if(classes.length > 0){
    classes.forEach((c, i) => {
      el.classList.add(c);
    });
  }

  if(str.length  > 0){
    el.innerHTML = str;
  }

  return el;

}

const gallery = document.getElementsByClassName('gallery');

/**
 * Old BitemsToDisplayer support
 */

 for (var i = 0; i < gallery.length; i++) {

   let items = gallery[i].getElementsByClassName('gallery-item');


   /**
    * Default values
    */
   let itemsToDisplay = 2;
   let step = 1;

   /**
    * First thing to do is to check for data gallery;
    */

    if(typeof gallery[i].dataset.gallery !== 'undefined'){
      itemsToDisplay = parseInt(gallery[i].dataset.gallery, 10); // Because array
    }

    if(typeof gallery[i].dataset.galleryStep !== 'undefined'){
      step = parseInt(gallery[i].dataset.galleryStep, 10); // Because array
    }

    /**
     * Then we need to *hide* all gallery-items - itemsToDisplay (toKeep)
     */

     for (var j = items.length - 1; j > itemsToDisplay - 1; j--) {
       items[j].classList.add("d-none");
     }


     let row = newDOMElement('div', ['row']);
     let col = newDOMElement('div', ['col-12', 'text-center']);
     let btn = newDOMElement('div', ['cta', 'cta-primary', 'c-pointer', 'text-white', 'mb-4', 'mx-auto'], 'Voir plus');



      // let btn = document.createElement('button');
      // btn.classList.add('btn', 'btn-primary', 'c-pointer', 'text-center', 'mx-auto');
      // btn.innerHTML = 'Voir plus';

      row.appendChild(col);
      col.appendChild(btn);
      gallery[i].appendChild(row);

      /**
       * Most important part : when user click the btn
       */


       btn.addEventListener('click', function (){

         for (var k = 0; k < step && itemsToDisplay <= items.length; k++) {

           items[itemsToDisplay].classList.remove("d-none");
           itemsToDisplay++;

         }

         if(itemsToDisplay >= items.length){
           btn.remove();
         }


       });



}
