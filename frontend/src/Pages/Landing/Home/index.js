import Footer from "../../../components/Footer/index";
import HomeBanner from "./HomeBanner";
import HomeInfo from "./HomeInfo";
import HomeConnect from "./HomeConnect";

export const Home = () => {
  return (
    <div id="starting-div">
      <HomeBanner />
      <HomeInfo />
      <HomeConnect />
      <Footer />
    </div>
  );
};
