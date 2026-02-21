export const MonthlySpend = (data) => {
  return (
    <div
      style={{ height: "fit-content" }}
      className="main-cards-wrapper col-md-12 col-lg-5 p-3"
    >
      <div className="main-card">
        <div className="row px-4 py-3 ">
          <div className="col-8">
            <p style={{ fontSize: "16px" }} className="text-white mt-2">
              Monthly Spend
            </p>
            <p
              style={{
                fontSize: "3rem",
                display: "block",
                fontWeight: 600,
              }}
              className="text-white"
            >
              {`$${data.monthlyTotal}.00`}
            </p>
            <div
              className="px-4  text-white"
              style={{
                background: "#2E3440",
                width: "fit-content",
                borderRadius: "15px",
              }}
            >
              {/* <p className="py-1">+10% Since last time</p> */}
            </div>
          </div>
          <div className="col-4">
            <div className="mb-4 mt-2">
              <li style={{ color: "#FC5B5B" }}>Unpaid</li>
              <p className="text-white my-2" style={{ fontSize: "1.35rem" }}>
                {`$${data.monthTotalUnpaid}.00`}
              </p>
            </div>
            <div>
              <li style={{ color: "#50E34D" }}>Paid</li>
              <p className="text-white my-2" style={{ fontSize: "1.35rem" }}>
              {`$${data.monthTotalPaid}.00`}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
