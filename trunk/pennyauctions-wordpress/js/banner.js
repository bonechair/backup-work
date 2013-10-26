var theImages = new Array() 

theImages[0] = 'embossedpaint.jpg'
theImages[1] = 'fallduck.jpg'
theImages[2] = 'flamingo.jpg'
theImages[3] = 'orange-lilly.jpg'
theImages[4] = 'peacockfeathers.jpg'
theImages[5] = 'rockies.jpg'
theImages[6] = 'shorebirds.jpg'
theImages[7] = 'embossedpaint2.jpg'
theImages[8] = 'white-rose.jpg'
theImages[9] = 'woodduck.jpg'
theImages[10] = 'zoozebra.jpg'
theImages[11] = 'shorebirds2.jpg'

var j = 0
var p = theImages.length;
var preBuffer = new Array()
for (i = 0; i < p; i++){
   preBuffer[i] = new Image()
   preBuffer[i].src = theImages[i]
}
var whichImage = Math.round(Math.random()*(p-1));
function showImage(){
document.write('<img src="img/'+theImages[whichImage]+'" width="997" alt="">');
}