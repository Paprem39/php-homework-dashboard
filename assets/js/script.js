/* ==========================================================
   WEB PROGRAMMING LABORATORY
   Student Portfolio
   JavaScript Version 1.0
========================================================== */



/* ==========================================================
   PAGE LOADED
========================================================== */

window.addEventListener("load", () => {

    document.body.classList.add("fade-in");

});



/* ==========================================================
   HEADER SHADOW
========================================================== */

const header = document.querySelector(".header");

window.addEventListener("scroll", () => {

    if(window.scrollY > 30){

        header.style.boxShadow = "0 15px 35px rgba(255,0,70,.18)";

    }

    else{

        header.style.boxShadow = "none";

    }

});



/* ==========================================================
   SCROLL REVEAL
========================================================== */

const revealElements = document.querySelectorAll(

".profile-card,.card"

);

const reveal = () =>{

    revealElements.forEach(el=>{

        const top = el.getBoundingClientRect().top;

        const height = window.innerHeight;

        if(top < height - 120){

            el.classList.add("fade-in");

        }

    });

}

window.addEventListener("scroll", reveal);

reveal();



/* ==========================================================
   CARD PARALLAX
========================================================== */

document.querySelectorAll(".card").forEach(card=>{

card.addEventListener("mousemove",(e)=>{

const rect = card.getBoundingClientRect();

const x = e.clientX - rect.left;

const y = e.clientY - rect.top;

card.style.transform=

`rotateX(${-(y-rect.height/2)/18}deg)
 rotateY(${(x-rect.width/2)/18}deg)
 translateY(-10px)`;

});


card.addEventListener("mouseleave",()=>{

card.style.transform="";

});

});



/* ==========================================================
   RIPPLE EFFECT
========================================================== */

document.querySelectorAll(".card,.github-btn")

.forEach(button=>{

button.addEventListener("click",(e)=>{

const ripple=document.createElement("span");

const rect=button.getBoundingClientRect();

const size=Math.max(rect.width,rect.height);

ripple.style.width=size+"px";

ripple.style.height=size+"px";

ripple.style.left=e.clientX-rect.left-size/2+"px";

ripple.style.top=e.clientY-rect.top-size/2+"px";

ripple.className="ripple";

button.appendChild(ripple);

setTimeout(()=>{

ripple.remove();

},600);

});

});



/* ==========================================================
   DIGITAL CLOCK
========================================================== */

function updateClock(){

const clock=document.getElementById("clock");

if(!clock) return;

const now=new Date();

clock.innerHTML=

now.toLocaleTimeString("th-TH");

}

setInterval(updateClock,1000);

updateClock();



/* ==========================================================
   CURRENT DATE
========================================================== */

function updateDate(){

const date=document.getElementById("date");

if(!date) return;

const now=new Date();

date.innerHTML=

now.toLocaleDateString("th-TH",{

weekday:"long",

year:"numeric",

month:"long",

day:"numeric"

});

}

updateDate();



/* ==========================================================
   SCROLL TO TOP
========================================================== */

const topButton=document.createElement("button");

topButton.innerHTML="▲";

topButton.id="topBtn";

document.body.appendChild(topButton);

topButton.style.cssText=`

position:fixed;
bottom:35px;
right:35px;
width:55px;
height:55px;
border:none;
border-radius:50%;
background:#ff0048;
color:white;
font-size:20px;
cursor:pointer;
display:none;
z-index:999;
box-shadow:0 0 25px rgba(255,0,70,.4);

`;

window.addEventListener("scroll",()=>{

if(window.scrollY>300){

topButton.style.display="block";

}else{

topButton.style.display="none";

}

});

topButton.onclick=()=>{

window.scrollTo({

top:0,

behavior:"smooth"

});

};



/* ==========================================================
   MOUSE GLOW
========================================================== */

const glow=document.createElement("div");

glow.style.cssText=`

position:fixed;
width:80px;
height:80px;
background:radial-gradient(circle,
rgba(255,0,70,.08),
transparent 70%);
pointer-events:none;
border-radius:50%;
transform:translate(-50%,-50%);
z-index:-1;
transition:.05s;

`;

document.body.appendChild(glow);

document.addEventListener("mousemove",(e)=>{

glow.style.left=e.clientX+"px";

glow.style.top=e.clientY+"px";

});



/* ==========================================================
   TYPE EFFECT
========================================================== */

const title=document.querySelector(".logo-area h1");

if(title){

const text=title.innerText;

title.innerHTML="";

let i=0;

function typing(){

if(i<text.length){

title.innerHTML+=text.charAt(i);

i++;

setTimeout(typing,60);

}

}

typing();

}



/* ==========================================================
   END
========================================================== */

console.log(

"WEB PROGRAMMING LABORATORY"

);

const canvas = document.getElementById("particles");

let ctx;
let particles = [];

if(canvas){

    ctx = canvas.getContext("2d");

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    for(let i=0;i<80;i++){

        particles.push({
            x: Math.random()*canvas.width,
            y: Math.random()*canvas.height,
            r: Math.random()*2,
            dx:(Math.random()-0.5)*0.5,
            dy:(Math.random()-0.5)*0.5
        });

    }

}

function animateParticles(){

    if(!canvas || !ctx) return;

    ctx.clearRect(0,0,canvas.width,canvas.height);

    particles.forEach(p=>{

        p.x += p.dx;
        p.y += p.dy;

        if(p.x<0 || p.x>canvas.width) p.dx *= -1;
        if(p.y<0 || p.y>canvas.height) p.dy *= -1;

        ctx.beginPath();
        ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
        ctx.fillStyle="rgba(255,0,70,.5)";
        ctx.fill();

    });

    requestAnimationFrame(animateParticles);

}

animateParticles();

window.addEventListener("load",()=>{

    const loader = document.getElementById("loader");

    if(loader){

        setTimeout(()=>{
            loader.classList.add("hide");
        },1000);

    }

});

const cursor = document.createElement("div");
cursor.classList.add("cursor");
document.body.appendChild(cursor);

document.body.classList.add("custom-cursor");

document.addEventListener("mousemove",(e)=>{
    cursor.style.left = e.clientX+"px";
    cursor.style.top = e.clientY+"px";
});

function resizeCanvas(){

    if(!canvas) return;

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

}

window.addEventListener("resize", resizeCanvas);
resizeCanvas();