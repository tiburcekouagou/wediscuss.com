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
  conversations: Conversation[];
};

export interface UserInfo extends User {
  blocked_at: null;
  email_verified_at: string;
  pivot: Pivot;
}

export interface Conversation {
  id: number;
  name: string;
  email?: string;
  is_group: boolean;
  is_user?: boolean;
  is_admin?: number;
  created_at: string;
  updated_at: string;
  blocked_at?: null;
  last_message: null | string;
  last_message_date: string | null;
  description?: string;
  owner_id?: number;
  users?: UserInfo[];
  user_ids?: number[];
}

export interface Pivot {
  group_id: number;
  user_id: number;
}
