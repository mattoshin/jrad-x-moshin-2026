import { faArrowsUpDown } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { Fragment, useEffect } from "react";
import useState from 'react-usestateref';
import MonitorCards from "./MonitorCards";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { useParams } from "react-router-dom";
import { getMonitorsbyId, updateWebhook as updateWebhookApi } from "../../../../api";

const Monitors = () => {
  const [isToastFinished, setIsToastFinished,toastRef] = useState(true);
  const [monitorChanges, setMonitorChanges,monitorChangesRef] = useState([]);
  const [isCurated, setCurated,curatedRef] = useState(false);
  const { id } = useParams();
  const [monitors, setMonitors,monitorsRef] = useState([]);
  const [controlChannels, setControlChannels,controlChannelRef] = useState([]);

  const getData = async() => {
    const res = await getMonitorsbyId(id);
    setMonitors(res.data.combined);
    setControlChannels(res.data.control_channels);
    if(res.data.channel_type == "Curated") {
      setCurated(true);
    }
  }

  useEffect(() => {
    getData();
  }, []);

  const Undo = ({ closeToast }) => {
    const handleClickSave = () => {
      let isCorrectDiscordUrl = true;

      monitorsRef.current.filter(webhook => webhook.webhook_url != null).map(change => {
        if (!change.webhook_url.match(/discord.com\/api\/webhooks\/([^\/]+)\/([^\/]+)/) && !change.webhook_url.match(/discordapp.com\/api\/webhooks\/([^\/]+)\/([^\/]+)/)){
          isCorrectDiscordUrl = false
        }
      });

      if (isCorrectDiscordUrl){
        
          
        const payload = {
          "changes": monitorsRef.current.filter(webhook => webhook.webhook_url != null).map((monitor) =>
            monitor
          )
        } 

        updateWebhookApi(id, payload).then(response=> {
          if(response.data.status == 'success') {
            toast.success('Webhooks Saved!', {
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
        

        closeToast();
        setIsToastFinished(false);
        
        setTimeout(() => {
          setIsToastFinished(true);
          setMonitorChanges([]);
          getData();
        }, 800);
      }
      else {
        toast.error('Invalid Discord URL - Please make sure all of the discord urls are correct!', {
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
    };

    const handleClickReset = () => {
      closeToast();
      setIsToastFinished(false);
      setTimeout(() => {
        setIsToastFinished(true);
        getData();
        setMonitorChanges([]);
      }, 800);
    };

    return (
      <Fragment>
        <div className="w-100 d-flex justify-content-between my-auto align-items-center">
          <p className="my-auto">Careful — you have unsaved changes!</p>
          <div className="d-flex my-auto">
            {/* <p className="p-0 my-auto" onClick={handleClickReset}>
              Reset
            </p> */}
            <button
              className="ms-3 p-2"
              style={{
                borderRadius: "4px",
                backgroundColor: "#00878c",
                border: "none",
                color: "white",
              }}
              onClick={handleClickSave}
            >
              Save Changes
            </button>
          </div>
        </div>
      </Fragment>
    );
  };

  const changeHandler = (id, info, method) => {
    if (!monitorChanges.includes(id)) {
      setMonitorChanges([...monitorChanges, id]);
    }
    if (method === "url") {
      const newMonitors = monitors.map((monitor) =>
      monitor.channel_id === id
        ? { ...monitor, webhook_url: info }
        : monitor
      );
      setMonitors(
        newMonitors
      );
     
    } else {
      const newMonitors = monitors.map((monitor) =>
      monitor.channel_id === id
        ? { ...monitor, enabled: info === true ? 1 : 0 }
        : monitor
      );
      setMonitors(
        newMonitors
      );
    }
    toast(<Undo />, {
      type: "default",
      toastId: "1",
      position: toast.POSITION.BOTTOM_CENTER,
    });
  };

  return (
    isCurated? <></>:
    <div className="main-cards-wrapper col-12 p-3">
      <div className="main-card">
        <div className="main-wrapper-up">
          <div className="row h-100 m-0 justify-content-between align-content-center d-flex">
            <div className=" col-2 col-md-0 align-items-center d-none d-md-flex text-white">
              <p className="m-0 mx-2 p-0" style={{ fontWeight: "bold" }}>
                Channel Name
              </p>
            </div>
            <div className="d-flex align-items-center  col-8  col-xxl-9 text-white">
              <p className="m-0 mx-2 p-0" style={{ fontWeight: "bold" }}>
                Webhook URL
              </p>
            </div>
            <div className="d-flex align-items-center  col-4 col-md-2 col-xxl-1 text-white">
              <p className="m-0 mx-2 p-0" style={{ fontWeight: "bold" }}>
                Enable
              </p>
            </div>
          </div>
        </div>
        <div
          style={{ height: "76%" }}
          className="mt-1 ms-0 me-0 cards-holder-active"
        >
          <h5 className="text-white">
            {monitors.map((monitor) => (
              <Fragment key={monitor.channel_id}>
                <MonitorCards
                  key={monitor.channel_id}
                  changedMonitors={monitorChanges}
                  toastRef={toastRef.current}
                  changeHandler={changeHandler}
                  monitor={monitor}
                  name={monitor.name}
                  controlChannelData={controlChannels}
                />
              </Fragment>
            ))}
          </h5>
        </div>
      </div>
    </div>
    
  );
};
export default Monitors;
