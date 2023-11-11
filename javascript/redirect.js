function redirect(){
    let sucesso = document.createElement("h1")
    sucesso.innerHTML = "Cadastro realizado com sucesso!"
    document.body.appendChild(sucesso)

    let mensagem = document.createElement("p")
    mensagem.innerHTML = `você será redirecionado em 5 segundos`
    document.body.appendChild(mensagem)

    let contador = 4
    for (let i = 5; i > 0; i--) {
        (function (indice) {
            setTimeout(function () {
                mensagem.innerHTML = `você será redirecionado em ${contador} segundos`
                contador--
            }, indice * 1000);
        })(i);
    }

    setTimeout(() => {
        window.location.href = "index.php"
    }, 5000);
}
