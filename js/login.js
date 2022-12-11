// const passwordToggle = document.querySelector(".password-toggle")
const passwordToggleIcon = document.querySelector(".password-toggle-icon")
const passwordInputBox = document.getElementById("password-input")
const usernameInputBox = document.getElementById("username-input")

const usernameDiv = document.querySelector(".modern-textbox.username")
const passwordDiv = document.querySelector(".modern-textbox.password")

const loginBtn = document.querySelector(".text-button.login-btn")

// console.log(passwordToggleIcon)
// console.log(passwordDiv)



// passwordToggle.addEventListener('click', () => {
//     if(passwordInputBox.type === "password"){
//         passwordInputBox.type = "text"
//         passwordToggle.textContent = "Hide"
//     } else {
//         passwordInputBox.type = "password"
//         passwordToggle.textContent = "Show"
//     }
// })


passwordToggleIcon.addEventListener('click', e => {
    // e.stopPropagation()
    if(passwordInputBox.type === "password"){
        passwordInputBox.type = "text"
        passwordToggleIcon.src = "images/icons-mono/hide-pw.png"
    } else {
        passwordInputBox.type = "password"
        passwordToggleIcon.src = "images/icons-mono/show-pw.png"
    }
})


usernameDiv.addEventListener('click', () => {
    usernameInputBox.focus()
})

passwordDiv.addEventListener('click', () => {
    passwordInputBox.focus()
})


loginBtn.addEventListener('click', () => {
    if(usernameInputBox.value == ""){
        usernameDiv.classList.add("no-content")
    }
    if(passwordInputBox.value == ""){
        passwordDiv.classList.add("no-content")
    }
})

usernameInputBox.addEventListener('input', ()=>{
    if(usernameDiv.classList.contains("no-content")){
        usernameDiv.classList.remove("no-content")
    }
})
passwordInputBox.addEventListener('input', ()=>{
    if(passwordDiv.classList.contains("no-content")){
        passwordDiv.classList.remove("no-content")
    }
})










const closeBtn = document.querySelector(".close-btn")
const signupBtn = document.querySelector(".register-btn")
const signupModal = document.querySelector(".signup-modal")
const modalCard = document.querySelector(".modal-card")

signupBtn.addEventListener('click', () => {
    signupModal.classList.add("active")
})

closeBtn.addEventListener('click', () => {
    signupModal.classList.remove("active")
})

// signupModal.addEventListener('click', ()=>{
//     signupModal.classList.remove("active")
// })
// modalCard.addEventListener('click', e => {
//     e.stopPropagation()
// })



const modernTextDiv = document.querySelectorAll(".modern-textbox.signup-input-div")
const modernTextInput = document.querySelectorAll(".modern-text-input.signup-input")

for(let i=0; i<modernTextDiv.length; i++){
    modernTextDiv[i].addEventListener('click', ()=> {
        modernTextInput[i].focus()
    })
}

usernameDiv.addEventListener('click', () => {
    usernameInputBox.focus()
})

const registerBtn = document.querySelector(".text-button.signup-btn")
let proceed = 0
let passwordPass = 0
let usernamePass = 0
const signupPassword = document.querySelector("#signup-password")
const signupConfirmPassword = document.querySelector("#signup-confirm-password")
const signupConfirmPasswordDiv = document.querySelector(".signup-input-div.signup-confirm-password")
const signupConfirmPasswordPlaceholder = document.querySelector(".placeholder.confirm-password")

const users = document.querySelectorAll(".username-list")
const txt = document.querySelector("#signup-username")
const signupUserInputDiv = document.querySelector(".signup-input-div.signup-username")
const signupUserPlaceholder = document.querySelector(".placeholder.username")

const emails = document.querySelectorAll(".email-list")
const emailtxt = document.querySelector("#signup-email")
const signupEmailInputDiv = document.querySelector(".signup-input-div.signup-email")
const signupEmailPlaceholder = document.querySelector(".placeholder.email")

function checkSignUp(){
    if(signupConfirmPasswordDiv.classList.contains("no-content") || 
    signupUserInputDiv.classList.contains("no-content") || 
    signupConfirmPassword.value == "" ||
    signupEmailInputDiv.classList.contains("no-content")){
        registerBtn.disabled = true
    } else{
        registerBtn.disabled = false
    }
}


signupConfirmPassword.addEventListener('input', ()=> {
    if(signupPassword.value != signupConfirmPassword.value){
        signupConfirmPasswordDiv.classList.add("no-content")
        signupConfirmPasswordPlaceholder.textContent = "Passwords does not match"
    }
    else{
        if(signupConfirmPasswordDiv.classList.contains("no-content")){
            signupConfirmPasswordDiv.classList.remove("no-content")
            signupConfirmPasswordPlaceholder.textContent = "Confirm Password"
        }
    }
    if(signupConfirmPasswordDiv.classList.contains("no-content") && signupConfirmPassword.value == ""){
        signupConfirmPasswordDiv.classList.remove("no-content")
        signupConfirmPasswordPlaceholder.textContent = "Confirm Password"
    }
    checkSignUp()
})

// signupPassword.addEventListener('input', ()=> {
//     if(signupPassword.value == ""){
//         if(signupConfirmPasswordDiv.classList.contains("no-content")){
//             signupConfirmPasswordDiv.classList.remove("no-content")
//             signupConfirmPasswordPlaceholder.textContent = "Confirm Password"
//         }
//     }
// })



        
        let usernamelist = []

        for(let i=0; i<users.length; i++){
            usernamelist.push(users[i].textContent)
        }
        console.log(usernamelist)



        txt.addEventListener("input", () => {
            // console.log("clicked")
            console.log(txt.value)
            
                // console.log(document.querySelectorAll(".usernames")[i].textContent)
                if(usernamelist.includes(txt.value)){
                    signupUserInputDiv.classList.add("no-content")
                    signupUserPlaceholder.textContent = "Username already exists"
                }
                else{
                    if(signupUserInputDiv.classList.contains("no-content")){
                        signupUserInputDiv.classList.remove("no-content")
                        signupUserPlaceholder.textContent = "Username"
                    }
                }
                checkSignUp()
            
        })





        let emaillist = []

        for(let i=0; i<emails.length; i++){
            emaillist.push(emails[i].textContent)
        }
        // console.log(usernamelist)



        emailtxt.addEventListener("input", () => {
            // console.log("clicked")
            // console.log(txt.value)
            
                // console.log(document.querySelectorAll(".usernames")[i].textContent)
                if(emaillist.includes(emailtxt.value)){
                    signupEmailInputDiv.classList.add("no-content")
                    signupEmailPlaceholder.textContent = "Email already linked"
                }
                else{
                    if(signupEmailInputDiv.classList.contains("no-content")){
                        signupEmailInputDiv.classList.remove("no-content")
                        signupEmailPlaceholder.textContent = "Email"
                    }
                }
                checkSignUp()
            
        })