export const ClientDetails = (props) => {
  return (
    <div className="main-cards-wrapper col-12 p-3 client-details-wrap">
      <div className="main-card">
        <div className="main-wrapper-up">
          <h5 className="text-white align-items-center d-flex h-100">
            Customer Details
          </h5>
        </div>
        <div className="row mx-3 my-3 text-white ">
          <div
            className="col-12 my-1 "
            style={{ lineHeight: "8px", borderBottom: "2px solid #2E323B", paddingBottom: "10px", paddingTop: "5px" }}
          >
            <p style={{ fontSize: "18px", fontWeight: "600"  }}>
              {props.invoice.billing_name}
              </p>
            <p style={{ fontSize: "15px", fontWeight: "300" }}>
              {props.invoice.billing_email}
            </p>
          </div>
          <div className="col-12 my-3" style={{ lineHeight: "8px" }}>
            <p style={{ fontSize: "18px", fontWeight: "600"  }}>
              {props.invoice.billing_name}</p>
            <p style={{ fontSize: "15px", fontWeight: "300" }}>
              {props.invoice.billing_address}
            </p>
          </div>
          <div className="col-12">
            <button
              style={{
                width: "100%",
                backgroundColor: "#171A23",
                border: "none",
                color: "#00878C",
                height: "55px",
                fontWeight: "600",
                borderRadius: "8px"
              }}
              type="button"
              className="btn btn-light"
            >
              Change Costumer
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};
