import { faLock } from "@fortawesome/free-solid-svg-icons";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { useNavigate } from "react-router-dom";

const NotAuthorized = () => {
  const navigate = useNavigate();
  return (
    <div
      className="w-100 d-flex align-items-center justify-content-center"
      style={{ height: "100vh" }}
    >
      <div>
        <FontAwesomeIcon
          className="w-100 m-auto"
          color="white"
          icon={faLock}
          style={{ fontSize: "50px" }}
        />
        <h1 className="text-white">Not authorized, please log in!</h1>
        <button
          style={{
            padding: "3px",
            backgroundColor: "white",
            fontWeight: "650",
            color: "black",
            borderRadius: "6px",
          }}
          onClick={() => navigate("/login")}
        >
          Take me there!
        </button>
      </div>
    </div>
  );
};
export default NotAuthorized;
