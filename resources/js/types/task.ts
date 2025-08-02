import { User } from './user';

export interface Task {
    id: number;
    name: string;
    description?: string;
    status: string;
    user_id?: number;
    user?: User;
    due_date?: string;
    completed_at?: string;
    estimate_hours?: number;
    actual_hours?: number;
    priority?: number;
}
