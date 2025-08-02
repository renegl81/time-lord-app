import { User } from './user';
export interface TimeEntry {
    id: number;
    description: string;
    started_at: string;
    ended_at: string | null;
    duration: number;
    user_id: number;
    user: User;
}
