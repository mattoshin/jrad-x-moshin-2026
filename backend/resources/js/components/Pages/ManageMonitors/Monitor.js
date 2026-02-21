import { SortAscendingIcon } from "@heroicons/react/outline"
import { Table } from "react-bootstrap"
import { LinkIcon } from "@heroicons/react/solid"
import React, { Component, useState } from "react"
import Switch from "./Switch";
import Alert from './Alert';
import toast, { Toaster } from 'react-hot-toast';
import Cookies from 'universal-cookie';
import './Switch.css';

class Monitor extends Component{
    constructor(){
        super()
        this.state={
            plan:'',
            webHooksData: [],
            planData: [],
            currentPlan: {},
            changes: [],
            
        };
        this.input=React.createRef();
    }
    componentDidMount=e=>{
        const cookies = new Cookies();
        let users = cookies.get('user')
        let userL = users.user.id

        if (!users.user.api_token){
            window.location.href= '/logout';
        }

        let uniqueNumber;
        axios.get('http://localhost:8000/api/plan/'+ userL)
        .then(res=> {
            uniqueNumber = res.data.id
            this.setState({
                plan: res.data.id
            })
            


        axios.get(`http://localhost:8000/api/webhooks/${uniqueNumber}`)
        .then(response => {
            this.setState({
                planData: response.data.map((hook) => ({...hook, plan: uniqueNumber}))
            })
        })
       
        axios.get('http://localhost:8000/api/channels')
        .then(res=>{
            this.setState({
                // monitorName:res.data,
                webHooksData: res.data.map((hook) => ({...hook, enabled: false,  plan: uniqueNumber}))
            })
        })

    }
        handleChange=e=>{
            e.preventDefault()
            const target = e.target;
            const name = target.name

            this.setState({
                [name]: target.value

            })
            const webhook={
                webhook_url:this.state.webhook_url,
                channel_id: this.state.channel_id,
                enable:this.state.enable
            }
        }
        onChange=e=>{
            e.preventDefault()
            this.setState({
                enable: !this.state.enable
            })
            const enabled = {
                enable: this.state.enable ? 1 : 0
            }

            axios.post('http://localhost:8000/api/webhooks', {enabled})
            .then(res=>res)

        }
            
        handleSubmit(channelObject, currentWebHook){
            // let planWebHookUrl = currentWebHook.weebhook_url;
            // axios.get(`http://localhost:8000/api/webhookz/${uniqueNumber}`)
            // .then(response => {
            //     this.setState({
            //         planData: response.data.map((hook) => ({...hook, plan: uniqueNumber}))
            //     })
            // })
            // }
            if (channelObject){
                if (channelObject.webhook_url.match(/discord.com\/api\/webhooks\/([^\/]+)\/([^\/]+)/) || channelObject.webhook_url.match(/discordapp.com\/api\/webhooks\/([^\/]+)\/([^\/]+)/)) {
                    let changedObject = {
                        channel_id: channelObject.channel_id,
                        enabled: channelObject.enabled,
                        plan: channelObject.plan,
                        webhook_url: channelObject.webhook_url,
                    }
                    axios.post('http://localhost:8000/api/webhooks', changedObject)
                    .then(res=>toast('Webhook Saved!'))
                    .catch(err=>toast("There has been an error, please contact an admin"))
                }else{
                    toast('Invalid Webhook URL')
                }
            }
            else {
                if (currentWebHook.weebHookUrl.match(/discord.com\/api\/webhooks\/([^\/]+)\/([^\/]+)/) || currentWebHook.weebHookUrl.match(/discordapp.com\/api\/webhooks\/([^\/]+)\/([^\/]+)/)) {
                    let changedObject = {
                        channel_id: currentWebHook.id,
                        enabled: currentWebHook.enabled,
                        plan: currentWebHook.plan,
                        webhook_url: currentWebHook.weebHookUrl,
                    }
                    axios.post('http://localhost:8000/api/webhooks', changedObject)
                    .then(res=>toast('Webhook Saved!'))
                    .catch(err=>toast("There has been an error, please contact an admin"))
                    }else{

                        toast('Invalid Webhook URL')
                    }
            }

                
                // if (planWebHookUrl ? planWebHookUrl.match(/discord.com\/api\/webhooks\/([^\/]+)\/([^\/]+)/) : currentWebHook?.weebHookUrl?.match(/discord.com\/api\/webhooks\/([^\/]+)\/([^\/]+)/)) {
                    // let changedObject = {
                    //     channel_id: currentWebHook.id,
                    //     enabled: currentWebHook.enabled,
                    //     plan: currentWebHook.plan,
                    //     webhook_url: currentWebHook.weebHookUrl || currentWebHook.webhook_url,
                    // }
                // }else{
                //     console.log("DOESNT MATCH")

                //     toast('Invalid Webhook URL')
                // }
            }
                

        handleUrlChange = (e, changedHook, isPlan) => {
            console.log(e.target.value)
           if (!isPlan) {
            let isExisting = this.state.changes.filter(data => data.id === changedHook.id)[0]
            if (!isExisting){
                let planObject = {weebHookUrl: e.target.value, id: changedHook.id }
                this.setState({
                    changes: [...this.state.changes, planObject]
                })
            }
            else {
                this.setState({
                    changes: this.state.changes.map(change => {
                        if (change.id === changedHook.id){
                            return {
                                ...change,
                                weebHookUrl: e.target.value
                            }
                         }
                         else {
                             return {...change}
                         }
                       })
                })
            }

            this.setState({
                webHooksData: this.state.webHooksData.map(currData => {
                    if (currData.id === changedHook.id ){
                       return {
                           ...currData,
                           weebHookUrl: e.target.value
                       }
                    }
                    else {
                        return {...currData}
                    }
                }),
               })
        }
        
            else {
                let isExisting = this.state.changes.filter(data => data.id === changedHook.id)[0]
            if (!isExisting){
                let planObject = {weebHookUrl: e.target.value, id: changedHook.id }
                this.setState({
                    changes: [...this.state.changes, planObject]
                })
            }
            else {
                this.setState({
                    changes: this.state.changes.map(change => {
                        if (change.id === changedHook.id){
                            return {
                                ...change,
                                weebHookUrl: e.target.value
                            }
                         }
                         else {
                             return {...change}
                         }
                       })
                })
            }
                this.setState({
                    planData: this.state.planData.map(currData => {
                        
                        if (currData.channel_id === changedHook.id ){
                           return {
                               ...currData,
                               webhook_url: e.target.value
                           }
                        }
                        else {
                            return {...currData}
                        }
                    })
                   })
            }

        }


        saveWebHooks = () => {
            let finalObject = {
                plan: this.state.plan,
                changes: this.state.changes
             }

            let isCorrectDiscordUrl = true;

            this.state.changes.map(change => {
                if (!change.weebHookUrl.match(/discord.com\/api\/webhooks\/([^\/]+)\/([^\/]+)/) && !change.weebHookUrl.match(/discordapp.com\/api\/webhooks\/([^\/]+)\/([^\/]+)/)){
                    isCorrectDiscordUrl = false
                }
            })

            if (isCorrectDiscordUrl){
                axios.post("http://localhost:8000/api/mwebhooks", finalObject)
                .then(res => {
                    toast('Changes Saved!')
                    // setTimeout(() => {  window.location.reload(false); }, 1000);
                })
                .catch(err => console.log(err))
            }
            else {
                toast('Invalid Discord URL - Please make sure all of the discord urls are correct')
            }

             
             console.log(finalObject)
        }

        handleTestWebHookUrl = (value) => {
            var instance = axios.create();
            delete instance.defaults.headers.common['X-CSRF-TOKEN'];
            delete instance.defaults.headers.common['X-Requested-With'];
            instance.post(value, {
                "content": null,
                "embeds": [
                  {
                    "description": "Test webhook",
                    "color": 26282,
                    "footer": {
                      "text": "Powered by mocean.info"
                    }
                  }
                ],
                "username": "Mocean Services",
                "avatar_url": "https://media.discordapp.net/attachments/951699541030232084/965425627832406036/ocean1.png",
                "attachments": []
              })
            .then(res => {
                toast('Webhook Valid, Sent the test.')
                // setTimeout(() => {  window.location.reload(false); }, 1000);
            })
            .catch(err => toast('Invalid Webhook'))
        }

        handleEnableChange = (changedHook, isPlan) => {
            if (!isPlan) {

                this.setState({
                    webHooksData: this.state.webHooksData.map(currData => {
                        if (currData.id === changedHook.id){
                            
                           return {
                               ...currData,
                               enabled: !changedHook.enabled
                           }
                        }
                        else {
                            return {...currData}
                        }
                   }),
                })
            }
                else {
                this.setState({
                    planData: this.state.planData.map(planData => {
                        if (planData.id === isPlan.id){
                            let enables = {
                                ...planData,
                                enabled: !planData.enabled
                            }
                            axios.post('http://localhost:8000/api/webhooks', enables).then(res=>console.log(res.data))
                           return {
                               ...planData,
                               enabled: !planData.enabled
                           }
                        }
                        else {
                            return {...planData}
                        }
                    })
                   })
                }
            }
            

            

       
        render(){

        const names = this.state.webHooksData.map((name, i)=>{
            const currentPlan = this.state.planData.filter(plan => plan.channel_id === name.id)[0]
            return(
                <tr class="">
                    <td id="monitorName">#{name.name}</td>
                    <td id="webhookContainer" colSpan="8" class="text-white d-flex my-2 ">
                    
                        <input type="text" id="inputBox" class="text-white mt-2 py-2 placeholder-white " defaultValue={currentPlan?.webhook_url.length ? currentPlan.webhook_url : name.weebHookUrl} key={i} name="webhook_url" onChange={(e) => this.handleUrlChange(e, name, currentPlan ? currentPlan :false )} placeholder="https://discordapp.com/webblbalb"></input>
                        <input type="hidden" ref={(input)=>this.input = input} onInput={(e)=>this.setState({
                            webhook:{
                                channel_id:e.target.values
                            }
                        })} value={name.id} key={i +name.name} name="channel_id" ></input>
                    
                    </td>
                    <td id="">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" onChange={() => this.handleEnableChange(name, currentPlan ? currentPlan :false)} checked={currentPlan?.enabled ? true : name.enabled}/>
                    </div>
                    </td>
                    <td className="col-1">
                    <button type="button" onClick={() => this.handleTestWebHookUrl(currentPlan?.webhook_url.length ? currentPlan.webhook_url : name.weebHookUrl)} className="table-button">Test Webhook</button>
                    </td>
                </tr>
            )
        })
    return(
        <div style={{paddingLeft:"12px", paddingRight:"12px"}}>
            <Toaster/>
            <div id="monitorsHeader">
                <h6 id="monitorsHeaderText" class ="">Monitors</h6>
                <button type="button" id="saveButton" onClick={this.saveWebHooks}>Save Webhooks</button>
            </div>
            <div onclick={this.setModalShow} class="table-responsive">
                <table class="">
                    <thead id="monitorsTableHead" class="text-white">
                        <tr>
                        <th class="">
                        Monitor Name
                        </th>
                        <th>
                        Webhook URL
                        </th>
                        <th id="switchContainerTable">Enabled</th>
                        <th>
                        Action
                        </th>
                        </tr>

                    </thead>
                    <tbody id="monitors" class="text-white">
                            {names}

                    </tbody>
                </table>
                </div>
                <Alert
                    {...this.state}
                    show={this.state.modalShow}
                    onHide={()=>setModalShow(false)}
                />
        </div>
    )
    }
}

export default Monitor

