const env = {
    API_URL: import.meta.env.VITE_HOST,
    API_KEY: import.meta.VITE_API_KEY
};
console.log('env', env)
export default env;
