const BottomSection = ({ name, companyName, imgUrl }) => {
  return (
    <>
      <div>
        <img
          style={{
            marginLeft: "30px",
            borderRadius: "30px",
          }}
          height="50"
          width="50"
          src={imgUrl}
        />
      </div>

      <div
        style={{
          marginLeft: "20px",
        }}
        className="p-0"
      >
        <h6 className="review-card-name-text">{name}</h6>
        <h6 className="review-card-company-text">{companyName}</h6>
      </div>
    </>
  );
};

export default BottomSection;
