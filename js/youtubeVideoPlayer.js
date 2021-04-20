const videos =  document.getElementsByClassName("youtube-player");

for(let video of videos) {

  let id = video.dataset.id, img = video.dataset.img;

  // create a div
  div = document.createElement("div");
  div.setAttribute("data-id", video.dataset.id);
  div.setAttribute("data-height", video.dataset.height);

  div.innerHTML =  `<img class="img-fluid c-pointer" src="${img}">`;

  div.addEventListener('click', function (){

    var iframe = document.createElement("iframe");
    iframe.classList.add('w-100');
    iframe.setAttribute("src", `https://www.youtube.com/embed/${this.dataset.id}?autoplay=1`);
    iframe.setAttribute("frameborder", "0");
    iframe.setAttribute("height", this.dataset.height);
    iframe.setAttribute("allowfullscreen", "1");
    this.parentNode.replaceChild(iframe, this);


  });
  video.appendChild(div);
}
