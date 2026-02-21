import { useRef, useEffect } from "react";
import useState from 'react-usestateref';
import { ToastContainer, toast } from "react-toastify";
import { useParams } from "react-router-dom";
import { 
  updatePlan as updatePlanApi,
  getPlan as getPlanApi,
  checkout as checkoutApi
} from "../../../../api";
import { ChromePicker } from "react-color";
import Popup from 'reactjs-popup';
import { useOnClickOutside } from "../../../../helpers";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faCircleInfo,
} from "@fortawesome/free-solid-svg-icons";
const Settings = ({setOpen}) => {
  const [settingsData, setSettingsData, settingsRef] = useState({
    companyName: "",
    hexCode: "",
    picture: "",
    role: "",
  });
  const [planName, setPlanName] = useState("Product");
  const [planStatus, setPlanStatus] = useState(false);
  const [showColorPicker, setShowColorPicker] = useState(false);
  const ref = useRef();
  const purchaseRef = useRef();
  useOnClickOutside(ref, () => setShowColorPicker(false));

  const { id } = useParams();

  const getData = async () => {
    const planRes = await getPlanApi(id);
    setSettingsData({
      ...settingsData,
      'companyName': planRes.data.name,
      'hexCode': planRes.data.color,
      'picture': planRes.data.picture,
      'role': planRes.data.role,
    });
    setPlanName(planRes.data.plan_name);
    setPlanStatus(planRes.data.cancel);
  };

  useEffect(()=>{
    getData();
  }, [id]);
  const getCheckoutLink = async () => {	
    const res = await checkoutApi(id, localStorage.getItem("business_token"));
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
  }
  const onPurchase = () => {
    getCheckoutLink();
  }
  const updatePlan = async(payload) => {
    const res = await updatePlanApi(id, payload);
    if(res.data.status == "error") {
      toast.error(res.data.message, {
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
      toast.success("Changed Saved!", {
        style: {width: "300px", margin: "auto"},
        position: "top-center",
        autoClose: 4000,
        hideProgressBar: false,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        progress: undefined,
      });
    }
  }

  const onSave = () => {
    let input = settingsRef.current.hexCode ?? "";
    const reg = /^#[0-9A-F]{6}$/i;
    let inputTwo = settingsRef.current.picture ?? "";
    const urlMatch = /\.(jpeg|jpg|gif|png)$/i;

    if(settingsRef.current.companyName != "" && settingsRef.current.companyName != null && reg.test(input) && inputTwo.match(urlMatch)){
      const payload = {
        "name": settingsRef.current.companyName,
        "color": settingsRef.current.hexCode,
        "picture": settingsRef.current.picture,
        "role": settingsRef.current.role,
      };
      updatePlan(payload);
    }else{
      let errorMessage = "Error, Please check your inputs. Invalid Paramaters: "
      let invalidParams = []
      // if(settingsRef.current.companyName == "" || settingsRef.current.companyName == null){
      //   invalidParams.push("Name");
      // }
      if(!reg.test(input) && input != ""){
          invalidParams.push("Hexcode")
      }
      if(!inputTwo.match(urlMatch) && inputTwo != ""){
        invalidParams.push("Image URL")
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
    }
  }

  return (
    <div className="main-cards-wrapper col-md-12 col-lg-8 p-3">
      <div className="main-card">
        <div className="main-wrapper-up">
          <div class="d-flex justify-content-between h-100">
            <h5 className="text-white pt-3">
              {planName} Settings
            </h5>
            <button style={ planStatus == 1 ? {
              color: "#50E34D",
              backgroundColor: "transparent",
              padding: "3px 3px",
              border: "1px solid rgba(80, 227, 77, 0.3)",
              borderRadius: "8px",
              height: "35px",
              width: "180px",
              marginTop: "10px",
              marginRight: "10px"
            } : {
              color: "#FC5B5B",
              backgroundColor: "transparent",
              padding: "3px 3px",
              border: "1px solid rgba(252, 91, 91, 0.3)",
              borderRadius: "8px",
              height: "35px",
              width: "180px",
              marginTop: "10px",
              marginRight: "10px"
            }}
            onClick={() => planStatus ? onPurchase() : setOpen(true)}
            >
              {planStatus ? 'Resubscribe' : 'Cancel Subscription'}
            </button>
          </div>
        </div>
        <div
          className="mt-1 ms-0 me-0 cards-holder-active"
          style={{ height: "78%" }}
        >
          <div className="row">
            <div
              className="col-md-12 col-lg-8 mt-2"
              style={{ height: "100px" }}
            >
              <label
                className="text-white"
                style={{ fontWeight: "450", marginBottom: "4px" }}
              >
                Webhook Name
              </label>
              <input
                className="monitor-settings-input form-control"
                type="text"
                value={settingsData.companyName}
                onChange={(e) =>
                  setSettingsData({
                    ...settingsData,
                    companyName: e.target.value,
                  })
                }
                placeholder="Enter Webhook name"
              />
            </div>

            <div
              className="col-md-12 col-lg-4 mt-2"
              style={{ height: "100px" }}
            >
              <label
                className="text-white"
                style={{ fontWeight: "450", marginBottom: "4px" }}
              >
                Hex Code
              </label>
              <input
                className="monitor-settings-input form-control"
                type="text"
                value={settingsData.hexCode}
                
                // onChange={(e) =>
                //   setSettingsData({ ...settingsData, hexCode: e.target.value })
                // }
                onClick={() => setShowColorPicker(showColorPicker => !showColorPicker)}
                placeholder="Pick Color Hexcode #000000"
              />
              
              { showColorPicker && (
                <div
              
                  style={{
                    position: "absolute",
                    zIndex: "9999"
                  }}
                  ref={ref}
                >
                  <ChromePicker
                    color={settingsData.hexCode ?? "#fff"}
                    onChange={updatedColor => setSettingsData({ ...settingsData, hexCode: updatedColor.hex })}
                  />
                </div>
              )}
            </div>

            <div className="col-md-12 col-lg-8 mt-2" style={{ height: "100px" }}>
              <label
                className="text-white"
                style={{ fontWeight: "450", marginBottom: "4px" }}
              >
                Image URL
                <Popup    
                  trigger={open => (      
                    <button className="popup-icon"><FontAwesomeIcon icon={faCircleInfo} className="mr-2" /></button>
                  )}    
                  position="right center"    
                  closeOnDocumentClick  
                >
                  <span className="popup-ui"> Make sure that the URL has ‘.png’ at the end. </span>  
                </Popup>
              </label>
              <input
                className="monitor-settings-input form-control"
                type="text"
                value={settingsData.picture}
                onChange={(e) =>
                  setSettingsData({ ...settingsData, picture: e.target.value })
                }
                placeholder="Enter Picture URL"
              />
            </div>

            <div
              className="col-md-12 col-lg-4 mt-2"
              style={{ height: "100px" }}
            >
              <label
                className="text-white"
                style={{ fontWeight: "450", marginBottom: "4px" }}
              >
                Role
              </label>
              <input
                className="monitor-settings-input form-control"
                type="text"
                value={settingsData.role}
                onChange={(e) =>
                  setSettingsData({ ...settingsData, role: e.target.value })
                }
                placeholder="Enter Role Id"
              />
            </div>

            <div className="col-12 d-flex justify-content-end mb-2">
              <button
                style={{
                  color: "white",
                  width: "170px",
                  backgroundColor: "#00878C",
                  height: "52px",
                  border: "none",
                  fontWeight: "550",
                  borderRadius: "4px",
                }}
                onClick={onSave}
              >
                Save Changes
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
export default Settings;
