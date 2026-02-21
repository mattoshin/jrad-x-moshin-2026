import React, { Component } from "react";
import axios from "axios";
import ReactDOM from 'react-dom';
import { Container } from "react-bootstrap";
import { CookiesProvider } from 'react-cookie';
//import { Routes, Route, Switch,  } from "react-router";
import { BrowserRouter, Route, Routes, useLocation } from 'react-router-dom';
import classNames from "classnames";
import SideBar from "./SideBar.js";
import Content from "./Content.js";
import NavBar from "./Navbar.js";
import Cookies from 'universal-cookie';
import "bootstrap/dist/css/bootstrap.min.css";
import "./App.css";


class Home extends Component{

    constructor(props){
        super(props)
        this.state={
            render:0,
            user:{},
            isOpen: false,
            isMobile: true
        }
    
        this.previousWidth = -1;
    }
    UNSAFE_componentWillMount=e=>{

        const cookies = new Cookies();
        let users = cookies.get('user')
        
        cookies.set('tok', 1, { path: '/' });



    }

    updateWidth() {
      const width = window.innerWidth;
      const widthLimit = 856;
      const isMobile = width <= widthLimit;
      const wasMobile = this.previousWidth <= widthLimit;
  
      if (isMobile !== wasMobile) {
        this.setState({
          isOpen: !isMobile
        });
      }
  
      this.previousWidth = width;
    }



    componentDidMount=e=>{
        const cookies = new Cookies();
        let user = cookies.get('user')
        

       
        this.updateWidth();
        window.addEventListener("resize", this.updateWidth.bind(this));
      }
    
      /**
       * Remove event listener
       */
      componentWillUnmount() {
        window.removeEventListener("resize", this.updateWidth.bind(this));
      }
    
      toggle = () => {
        this.setState({ isOpen: !this.state.isOpen });
      };



    render(){

        const { search } = useLocation;

        return (

            <div className="App wrapper">
              <SideBar toggle={this.toggle} isOpen={this.state.isOpen} />
              <Content toggle={this.toggle} isOpen={this.state.isOpen} />
                {/* {<Header toggle={this.toggle} isOpen={this.state.isOpen}/>} */}
            </div>
  )
}
}
if(document.getElementById('manageMonitor')){
    const element = document.getElementById('manageMonitor')

    // create new props object with element's data-attributes
    // result: {tsId: "1241"}
    const props = Object.assign({}, element.dataset)
    ReactDOM.render(
    <BrowserRouter>
    <Home {...props}/>
    </BrowserRouter>
    , document.getElementById('manageMonitor'))
}



if(document.getElementById('accountSettings')){
    const elements = document.getElementById('accountSettings');

    const props = Object.assign({},elements.dataset)
  ReactDOM.render(
  <BrowserRouter>
  <Home {...props}/>
  </BrowserRouter>
  , document.getElementById('accountSettings'))
}
