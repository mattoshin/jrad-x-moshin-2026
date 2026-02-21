import {
  faEllipsisVertical,
  faEye,
  faFileArrowDown,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";

export const InvoiceDetailAction = () => {
  return (
    <div style={{ height: "10vh" }} className="main-cards-wrapper col-12 p-3">
      <div
        style={{
          display: "flex",
          flexDirection: "row",
          justifyContent: "space-between",
          flexWrap: "wrap",
        }}
        className="h-100"
      >
        <button
          style={{
            width: "47%",
            backgroundColor: "#1E222B",
            border: "none",
            color: "#00878C",
            height: "55px",
          }}
          type="button"
          className="btn btn-light"
        >
          <FontAwesomeIcon
            color="#00878C"
            icon={faEye}
            size="lg"
            style={{ transform: "translateX(-15px)" }}
          />
          View
        </button>
        <button
          style={{
            width: "47%",
            backgroundColor: "#1E222B",
            border: "none",
            color: "#00878C",
            height: "55px",
          }}
          type="button"
          className="btn btn-light"
        >
          <FontAwesomeIcon
            color="#00878C"
            icon={faFileArrowDown}
            size="lg"
            style={{ transform: "translateX(-15px)" }}
          />
          Download
        </button>
        <button
          style={{
            width: "100%",
            height: "55px",
            backgroundColor: "#00878C",
            border: "none",
            color: "#fff",
          }}
          type="button"
          className="btn btn-light w-100 m-0 mt-4"
        >
          Send Invoice
        </button>
      </div>
    </div>
  );
};
