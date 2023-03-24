import axios from "axios";
import React from "react";
import { Link } from "react-router-dom";
import "../styles/register.css";
import SignUp from "./SignUp";
import {Helmet} from 'react-helmet';

class SignInNext extends SignUp {
  constructor(props) {
    super(props);
    this.state = {
      username: "",
      do: true,
      birth: "",
    };
    this.signIn = this.signIn.bind(this);
    this.handleBirth = this.handleBirth.bind(this);
    this.handleUsrname = this.handleUsrname.bind(this);
    this.verify = this.verify.bind(this);
    this.disabled = this.disabled.bind(this);
  }

  disabled() {
    alert("Cette fonctionnalité n'est plus disponible.")
  }

  componentDidMount() {
    // disable submit button
    document.querySelector("button.register").style.backgroundColor = "#ccc";
    document.querySelector("button.register").style.color = "#808080";
    document.querySelector("button.register").disabled = true;
  }
  verify() {
    // check if everything is correct
    console.log(document.querySelector("#buttonSignIn").checked)
    console.log(this.state.username )
    console.log(this.state.birth)
    if (
      document.querySelector("#buttonSignIn").checked &&
      this.state.username &&
      this.state.birth
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
  handleBirth(event) {
    var input = event.target.value;
    this.setState({
      birth: input,
    });
    this.verify();
  }
  handleUsrname(event) {
    var input = event.target.value;
    this.setState({
      username: input,
    });
    this.verify();
  }

  signIn() {
    // check username
    axios
      .get("https://apivivide.leanguyen.fr/getUsers.php")
      .then((response) => {
        response.data.forEach((user) => {
          if (user.pseudo === this.state.username) {
            alert("Le nom d'utilisateur a déjà été choisi.");
            this.setState({
              do: false,
            });
          }
        });
      })
      .then(() => {
        if (this.state.do && this.state.username !== "") {
          const username = this.state.username;
          const email = sessionStorage.getItem("email");
          const pwd = sessionStorage.getItem("pwd");
          const birth = this.state.birth;
          const data = {
            username: username,
            email: email,
            password: pwd,
            birth: birth,
          };

          // signin the user
          axios
            .post("https://apivivide.leanguyen.fr/signin.php", JSON.stringify(data), {
              headers: {
                "Content-Type": "application/json",
              },
            })
            .then((res) => {
              console.log(res.data);
              sessionStorage.clear();
            })
            .then(() => {
              window.location.href = "https://vivide.leanguyen.fr/identification/connexion";
              // window.location.href ="http://localhost:3000/identification/connexion";
            });
        } else {
          alert("Veuillez enregistrer un nom d'utilisateur.");
        }
      });
  }
  render() {
    return (
      <div className="register">
        <Helmet>
            <title>Inscription : Etape n°2</title>
            <link rel="canonical" href="https://vivide.leanguyen.fr/inscription/next" />
        </Helmet>
        <button>
          <Link to="../inscription">Retour</Link>
        </button>
        <h1>Vous y êtes presque&nbsp;!</h1>
        {/* <p>Comment souhaitez-vous être nommé(e)&nbsp;?</p> */}
        <form action="" method="POST">
          <div className="input_label">
            <label htmlFor="username" className="label">
              Nom d'utilisateur<span>*</span>
            </label>
            <input
              className="reg_input"
              type="text"
              onKeyUp={this.handleUsrname}
              placeholder="ameliesmith"
            />
          </div>
          <div className="input_label">
            <label htmlFor="password2verify" className="label">
              Date de naissance<span>*</span>
            </label>
            <input
              className="reg_input birth"
              type="date"
              onChange={this.handleBirth}
              required
            />
          </div>
          <div className="remember_input_label">
            <input
              className="reg_input"
              type="checkbox"
              onClick={this.verify}
              id="buttonSignIn"
              required
            />
            <label htmlFor="remember">
              J'accepte les conditions d'utilisation
            </label>
          </div>
        </form>
        <button className="register" onClick={this.disabled}>
          Confirmer
        </button>
      </div>
    );
  }
}

export default SignInNext;
