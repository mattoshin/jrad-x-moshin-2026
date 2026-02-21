
import moment from 'moment';
export const InvoiceMonitorDetails = (props) => {
  return (
    <div className="main-cards-wrapper col-md-12 col-lg-5 p-3 w-100 h-100">
      <div className="main-card">
        <div className="row px-4 py-3 ">
          <div className="col-12 text-white">
            <p
              style={{ fontSize: "20px", fontWeight: "600", lineHeight: "0px" }}
              className="text-white mt-4"
            >
              Trading exclusive monitors
            </p>
            <p style={{ fontSize: "16px" }} className="text-white">
              Trading exclusive monitors
            </p>
          </div>
          <div
            className="col-12 row m-auto text-white p-2 mt-3"
            style={{
              backgroundColor: "#171A23",
              borderRadius: "10px",
            }}
          >
            <div className="col-12 col-lg-8 mt-2">
              <h6
                className="mb-3"
                style={{ fontSize: "18px", fontWeight: "600" }}
              >
                Invoice Number
              </h6>
              <p>
                INVOICE - #{props.invoice.id? props.invoice.id : ""}</p>
              <p style={{ fontWeight: "300" }}>
                Issued date :{" "}
                <span style={{ fontWeight: "600" }}>
                {props.invoice.creation_date? moment(props.invoice.creation_date).format('MMM Do, YYYY') : ""}</span>
              </p>
              <p style={{ fontWeight: "300" }}>
                Due date : <span style={{ fontWeight: "600" }}>Pending</span>
              </p>
            </div>
            <div className="col-12 col-lg-4 mt-2">
              <h6
                className="mb-3"
                style={{
                  fontSize: "18px",
                  fontWeight: "600",
                  textAlign: "right",
                }}
              >
                Billed to
              </h6>
              <p style={{ fontWeight: "300", textAlign: "right" }}>
                {props.invoice.billing_address? props.invoice.billing_address : ""}
              </p>
              {/* <p style={{ fontWeight: "300", textAlign: "right" }}>
                San Francisco
              </p>
              <p style={{ fontWeight: "300", textAlign: "right" }}>
                California, 9123
              </p> */}
            </div>
          </div>
          <div
            className="col-12 row m-auto my-3 text-white"
            style={{ paddingBottom: "10px", borderBottom: "2px solid #2E323B" }}
          >
            <div className="col-12 col-lg-8 mt-3">
              <h6
                style={{
                  fontSize: "18px",
                  fontWeight: "600",
                  lineHeight: "8px",
                }}
              >
                Item Detail
              </h6>
              <p>filler text</p>
            </div>
            <div className="col-12 col-lg-4 d-flex align-items-center my-3">
              <button
                style={{
                  width: "100%",
                  height: "35px",
                  backgroundColor: "#00878C",
                  border: "none",
                  color: "#fff",
                }}
                type="button"
                className="btn btn-light w-100 m-0 p-0"
              >
                Customize
              </button>
            </div>
          </div>
          <div
            className="col-12 row m-auto text-white mt-2"
            style={{ paddingBottom: "10px", borderBottom: "2px solid #2E323B" }}
          >
            <div className="col-6 col-lg-3">
              <h6 style={{ fontSize: "20px", fontWeight: "500" }}>Item Name</h6>
              <p>{props.invoice.product.name ? props.invoice.product.name : ""}</p>
            </div>
            <div className="col-6 col-lg-3">
              <h6 style={{ fontSize: "20px", fontWeight: "500" }}>Amount</h6>
              <p>{`$${props.invoice.payment_amount? props.invoice.payment_amount : "0"}`}.00</p>
            </div>
            <div className="col-6 col-lg-3">
              <h6 style={{ fontSize: "20px", fontWeight: "500" }}>Tax</h6>
              <p>$0.00</p>
            </div>
            <div className="col-6 col-lg-3">
              <h6 style={{ fontSize: "20px", fontWeight: "500" }}>Total</h6>
              <p>{`$${props.invoice.payment_amount? props.invoice.payment_amount : "0"}`}.00</p>
            </div>
          </div>
          <div
            className="col-12 row m-auto text-white py-2 mt-3"
            style={{ overflow: "auto" }}
          >
            <div className="col-12 col-lg-8">
              <div className="d-flex align-items-start">
                <h6 style={{ fontSize: "20px" }}>Payment Method</h6>
                <button className="change-payment my-0 py-0">
                  Change Method
                </button>
              </div>
              <p className="mt-3">Method Name: Stripe</p>
            </div>
            <div className="col-12 col-lg-4 mt-3 mt-lg-0">
              <div className="d-flex align-items-start justify-content-between">
                <h6 style={{ fontSize: "20px", fontWeight: "600" }}>
                  Sub Total
                </h6>
                <h6 style={{ fontSize: "20px", fontWeight: "600" }}>{`$${props.invoice.payment_amount? props.invoice.payment_amount : "0"}`}.00</h6>
              </div>
              <div className="d-flex align-items-start justify-content-between mt-1">
                <p>Discount</p>
                <p>$0.00</p>
              </div>
              <div className="d-flex align-items-start justify-content-between">
                <p style={{ fontWeight: "600" }}>Total</p>
                <h6 style={{ fontWeight: "600" }}>{`$${props.invoice.payment_amount? props.invoice.payment_amount : "0"}`}.00</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
