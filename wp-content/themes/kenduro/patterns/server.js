const cors = require('cors');
const express = require("express");
const app = express();
const axios = require("axios");
require('dotenv').config();

app.use(cors({
  origin: '*'
}));

const API_URL = 'https://app.smartsuite.com';

const request = async (params) => {
  try {
    const getAppsData = await axios({
      ...params,
      headers: {
        'Content-Type': 'application/json',
        Authorization: 'Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
        'ACCOUNT-ID': 'sd0y91s2',
      },
    });

    return getAppsData.data;
  } catch (error) {
    console.error('getAppsDataError: ', error);
    return error;
  }
};

app.get("/api/v1/:type", async (req, res) =>
  res.json(
    await request({
      method: "get",
      url: `${API_URL}/api/v1/${req.params.type}`,
    })
  )
);

app.get("/api/v1/applications/:id", async (req, res) =>
  res.json(
    await request({
      method: "get",
      url: `${API_URL}/api/v1/applications/${req.params.id}`,
    })
  )
);

// app.get("/api/v1/solutions/:id", async (req, res) =>
//   res.json(
//     await request({
//       method: "get",
//       url: `${API_URL}/api/v1/solutions/${req.params.id}`,
//     })
//   )
// );

app.post("/api/v1/applications/:id/records/list/", async (req, res) =>
  res.json(
    await request({
      method: "post",
      url: `${API_URL}/api/v1/applications/${req.params.id}/records/list/`,
      // data: req.body
    })
  )
);

app.listen(3003, () => {
  console.log("Server is listening on port 3003");
});
