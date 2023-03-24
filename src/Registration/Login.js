import axios from "axios";
import React from "react";
import { Link } from "react-router-dom";
import "../styles/register.css";
import SignUp from "./SignUp";
import {AiOutlineEye,AiOutlineEyeInvisible} from 'react-icons/ai';
import {Helmet} from 'react-helmet';

class Login extends SignUp {
  constructor(props) {
    super(props);
    this.state = {
      email: "",
      pwd: "",
      remember: false,
    };
    this.handleRemember = this.handleRemember.bind(this);
    this.login = this.login.bind(this);
    this.hide = this.hide.bind(this);
    this.disabled = this.disabled.bind(this);
  }
  componentDidMount(){
    // to hide the pswd
    document.querySelector('.openEye').style.display="none";
    if(localStorage.getItem('vivide_mode')===''){
      localStorage.setItem('vivide_mode',true);
    }
  }
  handleRemember() {
    // remember button
    this.setState((state) => ({
      remember: !state.remember,
    }));
  }
  disabled() {
    alert("Cette fonctionnalité n'est plus disponible.")
  }
  login(e) {
    e.preventDefault();
    let email = this.state.email;
    let pwd = this.state.pwd;
    let remember = this.state.remember;
    const data = {
      email: email,
      password: pwd,
      remember: remember,
    };
    // send data to check user
    axios
      .post("https://apivivide.leanguyen.fr/login.php", JSON.stringify(data), {
        headers: {
          "Content-Type": "application/json",
        },
      })
      .then((response) => {
        if (response.status === 200 && response.data !== 0) {
          // set cookie expiry date
          let expiryDate = new Date();
          const month = (expiryDate.getMonth() + 1) % 12;
          expiryDate.setMonth(month);
          // set cookie
          if (this.state.remember) {
            document.cookie ="token=" + response.data.token + ";path=/;secure;expires=" +expiryDate.toGMTString();
          } else {
            document.cookie = "token=" + response.data.token + ";path=/;secure";
          }
          window.location.href = "https://vivide.leanguyen.fr/";
          // window.location.href = "http://localhost:3000/";
        }
      });
  }
  hide(event){
    // hide show pswd
    if (event.type === "mousedown") {
      document.querySelector('.openEye').style.display="initial";    
      document.querySelector('.hideEye').style.display="none"; 
      document.querySelector('.hide_pswd').setAttribute('type','text');
    } else if (event.type === "mouseup"){
      document.querySelector('.hideEye').style.display="initial";    
      document.querySelector('.openEye').style.display="none";
      document.querySelector('.hide_pswd').setAttribute('type','password');
    }
  }
  render() {
    return (
      <div className="register">
      <Helmet>
          <title>Connexion</title>
          <link rel="canonical" href="https://vivide.leanguyen.fr/identification/connexion" />
      </Helmet>
        <h1>Connexion</h1>
        <p>Accédez à l'expérience Vivide&nbsp;!</p>
        <form>
          <div className="input_label">
            <label className="label" htmlFor="email">
              Email<span>*</span>
            </label>

            <input
              class="reg_input"
              type="email"
              onChange={this.handleEmail}
              placeholder="ameliesmith@gmail.com"
              name="email"
            />
          </div>

          <div className="input_label hide">
            <label className="label" htmlFor="password">
              Mot&nbsp;de&nbsp;passe<span>*</span>
            </label>
            <input
              class="reg_input hide_pswd"
              type="password"
              onChange={this.handlePwd}
              placeholder="************"
              name="password"
            />
            <AiOutlineEyeInvisible onMouseDown={this.hide} className="hideEye eye"/>
            <AiOutlineEye onMouseUp={this.hide} className="openEye eye"/>
          </div>

          <div className="remember_input_label">
            <input
              class="reg_input"
              type="checkbox"
              onChange={this.handleRemember}
              name="remember"
            />
            <label htmlFor="remember">Se souvenir de moi</label>
          </div>

          <a className="forgot" onClick={this.disabled}>
            Mot de passe oublié&nbsp;?
          </a>
          <button className="register" onClick={this.disabled}>
            Connexion
          </button>
        </form>
        <Link to="./inscription">
          Pas de compte&nbsp;?<span> Inscrivez-vous&nbsp;!</span>
        </Link>
      </div>
    );
  }
}

export default Login;
