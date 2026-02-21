import "./MonitorCards.css";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faLink } from "@fortawesome/free-solid-svg-icons";
import { useEffect } from "react";
import useState from 'react-usestateref';

const MonitorCards = ({
  monitor,
  changeHandler,
  toastRef,
  changedMonitors,
  name,
  controlChannelData
}) => {
  const [disable, setDisable] = useState(false);
  useEffect(()=>{
    controlChannelData.map((data)=>{
      if(data.id == monitor.channel_id) {
        setDisable(false);
      } else {
        setDisable(true);
      }
    })
  }, [])

  return (
    <div
      className="row mb-1 py-1"
      style={{
        height: "fit-content",
      }}
    >
      <div
        className="col-2 align-items-center d-none d-md-flex"
        style={{ overflowX: "overlay" }}
      >
        <h6 className="text-white m-0"
        style={{ fontWeight: "600"}}>#{name}</h6>
      </div>

      <div className="col-8  col-xxl-9" style={{ overflowX: "overlay" }}>
        <div
          className="m-0 p-0"
          style={{
            display: "flex",
            alignItems: "center",
            backgroundColor: "rgba(23, 26, 35, 0.5)",
            color: "#acacac",
            borderRadius: "10px",
            overflow: "auto",
            height: "40px",
          }}
        >
          <FontAwesomeIcon
            className="my-auto ms-2"
            color="#acacac"
            icon={faLink}
            size="xs"
          />
          <input
            className="input-products"
            type="text"
            placeholder="Insert Webhook URL"
            disabled={!toastRef}
            defaultValue={
              toastRef? monitor.webhook_url :
              !toastRef && changedMonitors.includes(monitor.channel_id)
                ? "Applying..."
                : monitor.webhook_url
            }
            onChange={(e) => changeHandler(monitor.channel_id, e.target.value, "url")}
            style={{
              height: "100%",
              width: "100%",
              outline: "none",
              backgroundColor: "transparent",
              paddingLeft: "15px",
              border: "none",
              color: "red !important",
              fontSize: "16px",
            }}
          />
        </div>
      </div>

      <div
        className="d-flex align-items-center  col-4 col-md-2 col-xxl-1"
        style={{ overflowX: "overlay",  paddingLeft: "0px !important"}}
      >
        <label className="switch">
          <input
            type="checkbox"
            defaultChecked={monitor.enabled}
            onChange={(e) => changeHandler(monitor.channel_id, e.target.checked, "checkbox")}
            // disabled={disable}
          />
          <span className="slider round" />
        </label>
      </div>
    </div>
  );
};

export default MonitorCards;
