# API Reference

All external APIs used by MonitorBot, organized by vertical.

---

## Stocks

### Finnhub (https://finnhub.io)
- **Base URL**: `https://finnhub.io/api/v1`
- **Auth**: API key via `X-Finnhub-Token` header or `token` query param
- **Free tier**: 60 calls/min
- **Endpoints used**:
  - `GET /quote?symbol={ticker}&token={key}` — Real-time stock quote
  - `GET /stock/insider-sentiment?symbol={ticker}&from={date}&to={date}&token={key}` — Insider sentiment (MSPR)
  - `GET /calendar/earnings?symbol={ticker}&token={key}` — Earnings calendar
  - `GET /news?category=general&token={key}` — Market news
  - `GET /company-news?symbol={ticker}&from={date}&to={date}&token={key}` — Company-specific news

---

## Crypto

### CoinGecko (https://www.coingecko.com)
- **Base URL**: `https://api.coingecko.com/api/v3`
- **Auth**: Optional API key via `x-cg-demo-api-key` header
- **Free tier**: 30 calls/min, 10K calls/month
- **Endpoints used**:
  - `GET /simple/price?ids={coin}&vs_currencies=usd&include_24hr_change=true&include_market_cap=true` — Price data
  - `GET /search/trending` — Trending coins

### Alternative.me Fear & Greed (https://alternative.me/crypto/fear-and-greed-index/)
- **Base URL**: `https://api.alternative.me`
- **Auth**: None required
- **Free tier**: Unlimited
- **Endpoints used**:
  - `GET /fng/?limit=1` — Current Fear & Greed Index

### DeFi Llama (https://defillama.com)
- **Base URL**: `https://api.llama.fi`
- **Auth**: None required
- **Free tier**: Unlimited
- **Endpoints used**:
  - `GET /v2/historicalChainTvl` — Historical DeFi TVL

---

## Sports

### The Odds API (https://the-odds-api.com)
- **Base URL**: `https://api.the-odds-api.com/v4`
- **Auth**: API key via `apiKey` query param
- **Free tier**: 500 credits/month
- **Endpoints used**:
  - `GET /sports/{sport_key}/odds?apiKey={key}&regions=us&markets=h2h` — Live odds

### ESPN (undocumented)
- **Base URL**: `https://site.api.espn.com/apis/site/v2`
- **Auth**: None required
- **Free tier**: Unlimited (undocumented API)
- **Endpoints used**:
  - `GET /sports/{sport_path}/scoreboard` — Live scores

**Sport keys mapping**:
| User input | Odds API key | ESPN path |
|------------|-------------|-----------|
| nfl | americanfootball_nfl | football/nfl |
| nba | basketball_nba | basketball/nba |
| mlb | baseball_mlb | baseball/mlb |
| nhl | icehockey_nhl | hockey/nhl |
| soccer | soccer_epl | soccer/eng.1 |
| mma | mma_mixed_martial_arts | mma/ufc |

---

## Trading Cards

### PokemonTCG.io (https://pokemontcg.io)
- **Base URL**: `https://api.pokemontcg.io/v2`
- **Auth**: Optional API key via `X-Api-Key` header
- **Free tier**: 20,000 requests/day (1,000 without key)
- **Endpoints used**:
  - `GET /cards?q=name:{name}&pageSize=5` — Search cards by name
  - `GET /cards/{id}` — Get card details with prices (cardmarket/tcgplayer)
  - `GET /sets?q=name:{set_name}` — Search card sets

---

## Real Estate

### FRED (https://fred.stlouisfed.org)
- **Base URL**: `https://api.stlouisfed.org/fred`
- **Auth**: API key via `api_key` query param
- **Free tier**: 120 calls/min
- **Endpoints used**:
  - `GET /series/observations?series_id=MORTGAGE30US&api_key={key}&file_type=json&sort_order=desc&limit=5` — 30-year mortgage rate
  - `GET /series/observations?series_id=CSUSHPINSA&api_key={key}&file_type=json&sort_order=desc&limit=5` — Case-Shiller Home Price Index

---

## News & Sentiment

### GDELT (https://www.gdeltproject.org)
- **Base URL**: `https://api.gdeltproject.org/api/v2`
- **Auth**: None required
- **Free tier**: ~100 calls/min
- **Endpoints used**:
  - `GET /doc/doc?query={query}&mode=ArtList&maxrecords=5&format=json` — Full-text news search

---

## Miscellaneous

### CheapShark (https://www.cheapshark.com)
- **Base URL**: `https://www.cheapshark.com/api/1.0`
- **Auth**: None required
- **Free tier**: ~60 calls/min
- **Endpoints used**:
  - `GET /deals?pageSize=5&sortBy=Deal%20Rating&title={title}` — Game deals
  - `GET /games?title={title}` — Game search

### USASpending (https://www.usaspending.gov)
- **Base URL**: `https://api.usaspending.gov/api/v2`
- **Auth**: None required
- **Free tier**: Unlimited
- **Endpoints used**:
  - `POST /search/spending_by_award` — Government contract search

### National Weather Service (https://weather.gov)
- **Base URL**: `https://api.weather.gov`
- **Auth**: None required (User-Agent header recommended)
- **Free tier**: ~60 calls/min
- **Endpoints used**:
  - `GET /points/{lat},{lon}` — Get forecast office/grid for coordinates
  - `GET /gridpoints/{office}/{gridX},{gridY}/forecast` — Detailed forecast
