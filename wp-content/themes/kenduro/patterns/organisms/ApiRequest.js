
import axios from "axios";

const API_URL = 'http://localhost:3003';

// Create AxiosInstance with preferred setup
const apiInstance = axios.create({
  timeout: 5000,
  headers: {
    'Content-Type': 'application/json',
    Authorization: 'Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
    'ACCOUNT-ID': 'sd0y91s2',
  },
});

const request = async (params) => {
  try {
    const response = await apiInstance(params);
    // console.log('REQUEST: ', response.data);
    return response.data;
  } catch (error) {
    console.error('requestError: ', error);
    throw error;
  }
};

export { request, API_URL };