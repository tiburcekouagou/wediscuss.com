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
  selectedConversation?: Conversation;
  messages?: Messages;
};

export interface Messages {
  data: MessageData[];
  links: MessageLinks;
  meta: MessageMeta;
}

export interface MessageData {
    id:          number;
    message:     string;
    sender_id:   number;
    sender:      User;
    receiver_id?: number;
    group_id?:    number;
    attachments?: MessageAttachment[];
    created_at:  Date;
    updated_at:  Date;
}
export interface MessageLink {
  first: string;
  last: string;
  prev?: string;
  next?: string;
}
export interface MessageMeta {
  current_page: number;
  from: number;
  to: number;
  links: MessageLink[];
  path: string;
  per_page: number;
  total: number;
  last_page: number;
}
export interface MessageAttachment {}

export interface UserInfo extends User {
  blocked_at: null;
  email_verified_at: string;
  pivot: Pivot;
}

export interface Conversation {
  id: number;
  name: string;
  avatar: string;
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
