import React, {Fragment} from 'react';
import {BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import img from '../images/icon_o.png';
import '../styles/register.css';
import Login from './Login';
import SignIn from './Signin';
import SignInNext from './SingInNext';

class Register extends React.Component {
    render() {
        return (
            <div className='body_register'>
                <div className="img_register">
                    <img src={img} alt=""/>
                </div>
                <Router>
                    <Fragment>
                        <Switch>
                            <Route exact path="/identification/connexion" component={Login} />
                            <Route exact path="/identification/inscription" component={SignIn} />
                            <Route exact path="/identification/inscription/next" component={SignInNext} />
                        </Switch>
                    </Fragment>
                </Router>
            </div>
        )
    }
}

export default Register;