import { useEffect, useState } from "react";
import { 
  businessCreate as businessCreateApi
} from "../../api";

const Guild = () => {
  const [error, setError] = useState("");

  const initiateAuth = async (guildId) => {
    try {
      const res = await businessCreateApi(guildId.toString());
      if(!res.data.token) {
        setError(res.data.error || "Error occur while creating business");
      }
      localStorage.setItem("business_token", res.data.token);
      window.close();
    } catch (error) {
      setError(`error while initiating business creation:" ${error}`);
    }
  };

  useEffect(() => {
    const search = window.location.search;
    const params = new URLSearchParams(search);
    const guildId = params.get("guild_id");
    initiateAuth(guildId);
  }, []);
  return (
    <div>
    </div>
  );
};

export default Guild;
