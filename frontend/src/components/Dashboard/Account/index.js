import { useRef, useState, useEffect } from "react";
import {
  businessAtme as businessAtmeApi,
  updateBusinessAtme as updateBusinessAtmeApi,
  portalApi as portalApi
} from "../../../api";
import { FileUploader } from "react-drag-drop-files";
import { FileDrop } from "react-file-drop";
import { ToastContainer, toast } from "react-toastify";
import { AllInvoices } from "./AllInvoices";
import { PaymentDetails } from "./PaymentDetails";
import './AccountSettings.css';

const Account = () => {
  const [accountState, setAccountState] = useState({
    businessName: "",
    businessTwitter: "",
    businessWebsite: "",
    orderConfirmation: false,
    orderStatus: false,
    orderDelivered: false,
    emailNotification: false,
    businessEmail: "",
  });
  const fileInputRef = useRef(null);
  const portalRef = useRef(null);
  const saveRef = useRef(null);
  const switchPropertyNames = [
    "orderConfirmation",
    "orderStatus",
    "orderDelivered",
    "emailNotification",
  ];

  const getData = async () => {
    const businessInfoResponse = await businessAtmeApi();
    setAccountState({
      ...accountState,
      'businessName': businessInfoResponse.data.name,
      'businessEmail': businessInfoResponse.data.email,
      'businessTwitter': businessInfoResponse.data.twitter,
      'businessWebsite': businessInfoResponse.data.website,
    });
  };

  useEffect(()=>{
    getData();
  }, []);

  const onChangeHandler = (e, stateName) => {
    if (switchPropertyNames.includes(stateName)) {
      setAccountState({
        ...accountState,
        [stateName]: !accountState[stateName],
      });
    } else {
      setAccountState({ ...accountState, [stateName]: e.target.value });
    }
  };

  const saveHandler = () => {
    saveRef.current.disabled = "disabled";
    let input = accountState.businessTwitter ?? "";
    const reg = /^@[A-Za-z0-9_]{1,15}$/;
    let input2 = accountState.businessWebsite ?? "";
    const reg2 = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)/;
    let input3 = accountState.businessEmail ?? "";
    const reg3 = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    if(accountState.businessName == "" || accountState.businessName == null || accountState.businessTwitter == "" || accountState.businessTwitter == null || !reg.test(input) || !input2.match(reg2) || !reg3.test(input3)){
      saveRef.current.disabled = "";
      
      let errorMessage = "Error, Please check your inputs. Invalid Paramaters: "
      let invalidParams = []
      if(accountState.businessName == "" || accountState.businessName == null){
        invalidParams.push("Name");
      }
      if(!reg.test(input)){
          invalidParams.push("Twitter")
      }
      if(!input2.match(reg2)){
        invalidParams.push("URL")
      }
      if(!reg3.test(input3)){
        invalidParams.push("Email")
    }
      toast.error(`${errorMessage}${invalidParams.join(", ")}`, {
        style: {width: "600px", margin: "auto"},
        position: "top-center",
        autoClose: 4000,
        hideProgressBar: false,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        progress: undefined,
      });
    } else {
      const payload = {
        "name": accountState.businessName,
        "email": accountState.businessEmail,
        "twitter": accountState.businessTwitter,
        "website": accountState.businessWebsite,
      };
  
      updateBusinessAtmeApi(payload).then(res => {
        saveRef.current.disabled = "";
        if(res.data.status == "success") {
          getData();
          toast.success('Saved Settings!', {
            style: {width: "200px", margin: "auto"},
            position: "top-center",
            autoClose: 4000,
            hideProgressBar: false,
            closeOnClick: true,
            pauseOnHover: true,
            draggable: true,
            progress: undefined,
          });
        }
      })
    }
  };
  const getPortalLink = async () => {
    const res = await portalApi(localStorage.getItem("business_token"));
    
    if(res.data.status == "success") {
      window.location.href = res.data.checkout_link;
    } else {
      toast.error(res.data.message, {
        style: {width: "200px", margin: "auto"},
        position: "top-center",
        autoClose: 4000,
        hideProgressBar: false,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        progress: undefined,
      });
    }
    portalRef.current.disabled = "";
  }
  const onPortal = () => {
    portalRef.current.disabled = "disabled";
    getPortalLink();
  }
  const onTargetClick = () => {
    fileInputRef.current.click();
  };
  return (
    <div className="py-2 px-5">
      <h5 
        className="text-white" 
        style={{
          fontSize: "32px",
          fontWeight: "600"
        }}
      >Settings</h5> 
      <p 
        className="mb-4"
        style={{
          color: "#acacac"
        }}
      >Manage your prefences here</p> 
      
      <div className="w-100 d-flex justify-content-end mb-4">
        <button
          onClick={onPortal}
          ref={portalRef}
          style={{
            height: "40px",
            width: "180px",
            borderRadius: "5px",
            backgroundColor: "#00878C",
            color: "white",
            outline: "none",
            border: "none",
          }}
        >
          Manage Payments
        </button>
      </div>
      <div className="account-cards-wrapper col-12">
        <div className="account-card">
          <div className="account-wrapper-up">
            <h5 className="text-white align-items-center d-flex h-100">
              Business Settings
            </h5>
          </div>
          <div
            className="row p-4"
          >
            <div className="row">
              <div className="col-md-12 col-lg-6 mb-2" style={{ height: "100px" }}>
                <label
                  style={{ color: "#808080", fontWeight: "450", marginBottom: "4px" }}
                >
                  Business Name
                </label>
                <input
                  className="account-settings-input form-control"
                  type="email"
                  value={accountState.businessName}
                  placeholder="Enter Business Name"
                  onChange={(e) => onChangeHandler(e, "businessName")}
                />
              </div>
              <div className="col-md-12 col-lg-6 mb-2" style={{ height: "100px" }}>
                <label
                  style={{ color: "#808080", fontWeight: "450", marginBottom: "4px" }}
                >
                  Business Email
                </label>
                <input
                  className="account-settings-input form-control"
                  type="email"
                  value={accountState.businessEmail}
                  placeholder="Enter Business Email"
                  onChange={(e) => onChangeHandler(e, "businessEmail")}
                />
              </div>
              
              <div className="col-md-12 col-lg-6 mb-2" style={{ height: "100px" }}>
                <label
                  style={{ color: "#808080", fontWeight: "450", marginBottom: "4px" }}
                >
                  Business Twitter
                </label>
                <input
                  className="account-settings-input form-control"
                  type="email"
                  placeholder="Enter Business Twitter"
                  value={accountState.businessTwitter}
                  onChange={(e) => onChangeHandler(e, "businessTwitter")}
                />
              </div>
              
              <div className="col-md-12 col-lg-6 mb-2" style={{ height: "100px" }}>
                <label
                  style={{ color: "#808080", fontWeight: "450", marginBottom: "4px" }}
                >
                  Business Website
                </label>
                <input
                  className="account-settings-input form-control"
                  type="email"
                  placeholder="Enter Business Website"
                  value={accountState.businessWebsite}
                  onChange={(e) => onChangeHandler(e, "businessWebsite")}
                />
              </div>
              <div className="w-100 d-flex justify-content-end">
                <button
                  onClick={saveHandler}
                  ref={saveRef}
                  style={{
                    height: "40px",
                    width: "120px",
                    borderRadius: "5px",
                    backgroundColor: "#00878C",
                    color: "white",
                    outline: "none",
                    border: "none",
                  }}
                >
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
export default Account;
