export const headers = (token) => {
  return {
    Authorization: `Bearer ${token}`,
  };
};
