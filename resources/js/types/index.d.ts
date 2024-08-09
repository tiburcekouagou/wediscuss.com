export interface User {
  id: number;
  name: string;
  email: string;
  avatar?: string;
  is_admin: boolean;
  created_at: string;
  updated_at: string;
  last_message?: string;
  last_message_date?: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  auth: {
    user: User;
  };
};
