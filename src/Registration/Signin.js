import axios from "axios";
import React from "react";
import { Link } from "react-router-dom";
import "../styles/register.css";
import SignUp from "./SignUp";
import {Helmet} from 'react-helmet';

class SignIn extends SignUp {
  constructor(props) {
    super(props);
    this.state = {
      email: "",
      pwd: "",
      pwd2: "",
      terms: false,
    };
    this.atStepTwo = this.atStepTwo.bind(this);
    this.handlePwd2 = this.handlePwd2.bind(this);
  }
  componentDidMount() {
    // disable button
    document.querySelector("button.register").style.backgroundColor = "#ccc";
    document.querySelector("button.register").style.color = "#808080";
    document.querySelector("button.register").disabled = true;
  }
  atStepTwo(event) {
    event.preventDefault();
    let same = false;
    const pswd1 = document.querySelector('#password')
    const pswd2 = document.querySelector('#password2verify')
    // pswd match
    if( pswd1.value === pswd2.value &&
        pswd2.value !== "" &&
        pswd2.value.length > 5 &&
        pswd2.value.length < 17
    ){
      // verify email
      /*   axios
        .get("https://apivivide.leanguyen.fr/getUsers.php")
        .then((response) => {
            response.data.forEach((user) => {
            if (user.email === this.state.email) {
                alert("Un utilisateur est déjà inscrit avec cet email.");
                same = true;
            }
            return;
            });
        })
        .then(() => {
            if (same !== true) {
            sessionStorage.setItem("pwd", pswd1.value);
            sessionStorage.setItem("email", document.querySelector('#email').value);
            window.location.href = "https://vivide.leanguyen.fr/identification/inscription/next";
            }
            return;
        }); */
				window.location.href = "https://vivide.leanguyen.fr/identification/inscription/next";
    }else{
        alert("Vos mots de passe ne correspondent pas.")
    }

  }

  handlePwd2(event) {
    this.setState({
      pwd2: event.target.value,
    });
    this.verify();
  }

  handleEmail(event) {
    this.setState({
      email: event.target.value,
    });
    this.verify();
  }

  verify() {
    let includes = false;
    const symbols = [
      "!",
      "?",
      "/",
      "*",
      "&",
      "~",
      "#",
      "-",
      "^",
      "$",
      "%",
      ":",
      "."
    ];

    symbols.forEach((sym) => {
      if (this.state.pwd2.includes(sym)) {
        return (includes = true);
      }
    });
    // check if there's content 
    if (
      this.state.email !== "" &&
      this.state.email.includes('@')
    ) {
      document.querySelector("button.register").style.backgroundColor = "#AF77FF";
      document.querySelector("button.register").style.color = "#363636";
      document.querySelector("button.register").disabled = false;
    } else {
      document.querySelector("button.register").style.backgroundColor = "#ccc";
      document.querySelector("button.register").style.color = "#808080";
      document.querySelector("button.register").disabled = true;
    }
  }

  render() {
    return (
      <div className="register">
      <Helmet>
          <title>Inscription : Etape n°1</title>
          <link rel="canonical" href="https://vivide.leanguyen.fr/identification/inscription" />
      </Helmet>
        <h1>Inscrivez-vous&nbsp;!</h1>
        <form>
          <div className="input_label">
            <label htmlFor="email" className="label">
              Email <span>*</span>
            </label>
            <input
              className="reg_input"
              type="email"
              onKeyUp={this.handleEmail}
              placeholder="ameliesmith@gmail.com"
              required
              id="email"
            />
          </div>

          <div className="input_label">
            <label htmlFor="password" className="label">
              Mot&nbsp;de&nbsp;passe<span>*</span>
            </label>
            <input
              className="reg_input"
              type="password"
              onKeyUp={this.handlePwd}
              placeholder="**********"
              required
              id="password"
            />
          </div>

          <div className="input_label">
            <label htmlFor="password2verify" className="label">
              Confirmez&nbsp;le mot&nbsp;de&nbsp;passe<span>*</span>
            </label>
            <input
              className="reg_input"
              type="password"
              onKeyUp={this.handlePwd2}
              placeholder="**********"
              required
              id="password2verify"
            />
          </div>

          <ul>
            <li>*Au moins 1 symbole (!,?,/,*,&,~,#,-,^,$,%,:)</li>
            <li>*Entre 6 et 16 caractères</li>
          </ul>

          <button className="register" onClick={this.atStepTwo}>
            Etape suivante
          </button>
        </form>
        <Link to="./connexion">
          Déjà un compte&nbsp;?<span> Connectez-vous&nbsp;!</span>
        </Link>
      </div>
    );
  }
}

export default SignIn;
