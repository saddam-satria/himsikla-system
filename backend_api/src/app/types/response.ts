export type TResponse<T> = {
  message: string;
  error?: TError;
  totalData?: string | number;
  nextPage?: number | string;
  prevPage?: number | string;
  request?: string;
  status: string;
  data: null | T;
  statusCode?: number;
};

type TError = {
  message: string;
};
