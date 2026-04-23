
document.getElementById('changebackgorund').addEventListener('click', function(prime){
    document.body.style.backgroundColor = 'black'
    document.body.style.color = 'white'
    }
)
document.getElementById('backbackground').addEventListener('click', function(){
    document.body.style.backgroundColor = 'white'
    document.body.style.color = 'black'
    document.body.classList.toggle('dark-mode') 
})
