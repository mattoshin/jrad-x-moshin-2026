import { render } from "@testing-library/react";
import React, {useEffect, useState, Component} from "react";
import Announcements from "./Announcements";
import { Alert, Button } from "react-bootstrap";
import logo from './calender.png';
import Monitor from "./Monitor";
import axios from 'axios';
import toast, { Toaster } from 'react-hot-toast';
import Cookies from 'universal-cookie';
//import Cookies from "js-cookie";
//import { withCookies, Cookies } from 'react-cookie';
import { instanceOf } from 'prop-types';

//import { createRoot } from 'react-dom/client';
import ReactDOM from 'react-dom'
import { Route } from "react-router-dom";
import { Scrollbars } from "react-custom-scrollbars-2";


console.log(logo)



class ManagedMonitors extends React.Component{
        constructor(props){
            super(props);
            this.state={
                companyName:'',
                hexcode:'',
                imageUrl: '',
                    avatar:'',
                    username:'',
                monitorName:'',
                render:0,
                planD: {
                    id: 0,
                    color: '',
                    picture: '',
                    name: '',
                },
                planUpdate: {},
                user:[],
                   userId:'' ,


                product:{
                    id:'',
                    product:''
                }
            }
            ;
            this.handleSubmit = this.handleSubmit.bind(this);
        };

UNSAFE_componentWillMount=e=>{
		 const cookies = new Cookies();
        let users = cookies.get('user')
        let userL = users.user.id
        
        if (!users.user.api_token){
            window.location.href= '/logout';
        }
        this.setState({
            userId:userL
        })

            //https://ocean.cadash.net
            axios.get('http://localhost:8000/api/products')
            .then(res=>this.setState({
                product:res.data
            }))






        }
        componentDidMount(e){
            const cookies = new Cookies();
                    let users = cookies.get('user')
            let userL = users.user.id
            axios.get('http://localhost:8000/api/plan/'+ userL)
            .then(res=>{
                let planD= {        
                    ...this.state.planD,   
                    id : res.data.id,
                    color : res.data.color == null ? '' : res.data.color,
                    picture : res.data.picture == null ? '' :  res.data.picture ,
                    name : res.data.name == null ? '' :  res.data.name   
                }
                this.setState({
                    planD: planD
                })
        })}
        hexadecimal(e){
            let input = e
            
            if (/^#([A-Fa-f0-9]{6})$/.test(input) ) {
             this.setState({
                 hexcode:input
             })
            }
          Alert('not a Hexadecimal please input a correct Hexadecmial')
        }
      



    handleNameChange = (e, currData) => {
        
        e.preventDefault();
        console.log(e.target.value)
        let planD= {        
                ...this.state.planD,   
                id : currData.id,
                color : currData.color,
                picture : currData.picture,
                name : e.target.value.trim() == "" ? null : e.target.value
            }
            this.setState({
                planD: planD
            })
             
     }
     handleColorChange = (e, currData) => {
            
               
        let planD= {        
             ...this.state.planD,   
             id : currData.id,
             color : e.target.value,
             picture : currData.picture,
             name : currData.name
         }
         this.setState({
             planD: planD
         })
         
    }
    handlePictureChange = (e, currData) => {
            
               
        let planD= {        
             ...this.state.planD,   
             id : currData.id,
             color : currData.color,
             picture : e.target.value,
             name : currData.name
         }
         this.setState({
             planD: planD
         })
         
    }
         
 
         
        

        handleSubmit = (e) => {
            e.preventDefault();
            let input =this.state.planD.color
            const reg=/^#[0-9A-F]{6}$/i
            let inputTwo= this.state.planD.picture
            const urlMatch= /\.(jpeg|jpg|gif|png)$/i

            if(this.state.planD.name != "" && this.state.planD.name != null && reg.test(input) && inputTwo.match(urlMatch)){

                
                    
    
    
                    
    
                   
                const plan={
                    id:this.state.id,
                    user:this.state.userId,
                    name:this.state.companyName,
                    color:this.state.hexcode,
                    picture: this.state.imageUrl,
    
                }
                    //localhost:8000
                    //https://ocean.cadash.net
                axios.post('http://localhost:8000/api/plans' ,{...this.state.planD})
                .then(res =>toast('Saved changes!'))
                  .catch(err=>
                    toast('There has been an error, please contact an admin'))
                
            }else{
                let errorMessage = "Error, Please check your inputs. Invalid Paramaters: "
                let invalidParams = []
                if(this.state.planD.name == "" || this.state.planD.name == null){
                    invalidParams.push("Webhook Name");
                }
                if(!reg.test(input)){
                    invalidParams.push("Hexcode")
                }
                if(!inputTwo.match(urlMatch)){
                    invalidParams.push("Image URL")
                }
                toast(`${errorMessage}${invalidParams.join(", ")}`)
            }
            
           

        };


    render(){

        //const { isLoggedIn } = props;
       // setupField(document.getElementByName('hexcode'),/^[A-Fa-f0-9]+$/);
        const {userId}= this.state;
        return(
            <div id="manageMonitors"  >
                <div class="row">
                    <div class="col-xl-7 col-sm-12">
                        <div id="monitorSetting" class="text-white ">
                            <div class="">
                                <h6 id="monitorSettings" class ="">Monitor Settings</h6>
                            </div>
                            <div>
                                <form onSubmit={this.handleSubmit} class="monitorForm ms-1" >
                                    <div  /* id="manageMonitorSettingsInput"*/>
                                        <div class="row">
                                            <div  class="col-8 col-sm-8 col-md-8">
                                                <label  id="inputBoxCompany"/* class="block mx-1 my-1 ml-5"*/>
                                                    <span>Webhook Name</span>
                                                    <input id="inputBox" type="text" class="mt-1 py-2 placeholder-white text-white" name="companyName" onChange={(e) => this.handleNameChange(e, this.state.planD)} value={this.state.planD.name} placeholder="Webhook Name" required></input>
                                                </label>
                                            </div>
                                            <div class="col-4 col-sm-4 col-md-4 ">
                                                <label id="inputBoxHex" class="" >
                                                    <span>Hexcode</span>
                                                    <input id="inputBox" type='text' class="text-white mt-1 w-100 py-2 placeholder-white" name="hexcode" onChange={(e) => this.handleColorChange(e, this.state.planD)} value={this.state.planD.color} placeholder="#ffffff" required></input>
                                                    <input type="hidden" name="user" ref={(input) => { this.actionInput = input }} value={userId} onInput={(e)=>this.setState({
                                                        user:e.target.value
                                                    })}></input>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-8 col-md-12">
                                                <label id="inputBoxUrl" class="mt-3 my-1">
                                                    <span>Image URL</span>
                                                    <input type="text" id="inputBox" class="text-white mt-2 py-2 placeholder-white " name="imageUrl" onChange={(e) => this.handlePictureChange(e, this.state.planD)}  value={this.state.planD.picture} placeholder="https://imgur.com/" required></input>
                                                    <input type='hidden' name="userID" value={this.state.product.id} onInput={(e)=>this.setState({
                                                        product:e.target.value
                                                    })}></input>
                                                </label>
                                            </div>
                                        </div>
                                        <button id="SubmitButtonMonitorSettings"/*id="saveSettingsMonitor" */ /*onClick={this.handleSubmit}*/ class="text-white mt-3 mb-4 py-2" type="submit" value="Save Changes" >Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-sm-12">
                        {<Announcements/>}
                    </div>
                    <Scrollbars
      renderThumbVertical={() => (
        <div
          style={{
            backgroundColor: "#0F8CFF",
            bordeRight: "5px inset #1C6EA4",
borderRadius: "0px 31px 0px 31px",
width:"15px"
          }}
        ></div>
      )}
      style={{ width: "100%", height: "450px" }}
    >
                        {<Monitor handleChange={this.handleChange}
                            handleSubmit={this.handleSubmit}
                            props={this.state.monitorName}

                        />}
                        </Scrollbars>
                </div>
                <Toaster/>
            </div>




        
            );
        }
    }

export default ManagedMonitors

/*const container = document.getElementById("manageMonitors");
const root = createRoot(container);
root.render(<ManagedMonitors/>);
if(document.getElementById('manageMonitors')){
    ReactDOM.render(<ManagedMonitors/>, document.getElementById('manageMonitors'))
}
*/
