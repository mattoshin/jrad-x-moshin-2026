import { useNavigate } from "react-router-dom";

const ActiveProductCard = ({ product }) => {
  const nav = useNavigate();
  return (
    <div className="row mb-3 p-3 product-card-active" onClick={() => nav(`/manage/${product.id}`)}>
      <div
        className="col-4 col-xs-4 col-sm-4 col-md-3 col-lg-3 col-xl-3 d-flex align-items-center "
        style={{ overflowX: "overlay" }}
      >
        <h6 className="text-white m-0">{product.name}</h6>
      </div>
      <div
        className="col-3 d-none d-md-block d-flex align-item-center justify-content-center custom-table-cols-active progress-col "
        style={{ overflowX: "overlay" }}
      >
        <h6 className="text-white my-auto m-0">{product.channel_type}</h6>
      </div>
      <div
        className="col-4 col-xs-4 col-sm-4 col-md-3 col-lg-3 col-xl-3  custom-table-cols-active progress-col  "
        style={{ overflowX: "overlay" }}
      >
        <p className="text-white" style={{ margin: 0 }}>
          {product.price > 0 ? `$${product.price}.00` : 'Free'}
        </p>
      </div>
      <div
        className="col-4 col-xs-4 col-sm-4 col-md-3 col-lg-3 col-xl-3 custom-table-cols-active progress-col "
        style={{ overflowX: "overlay" }}
      >
        <div className=" align-items-center w-100 h-100 justify-content-center custom-table-cols-active progress-col">
          <div className="d-flex m-auto">
            <p className="w-100 m-0" style={product.days_left >= 14 ? product.days_left >= 7 ? {color:"#50E34D"} : {color: "#FFA23A"} : {color: "#FC5B5B"}}>
              {product.cancel ? 'Plan ends in ' : ''} {product.days_left < 1000 ? product.days_left : '∞' } {product.cancel ? 'days' : 'days left'}
            </p>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ActiveProductCard;
