import { User } from './user';
import { Project } from '@/types/project';

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
    project_id?: number;
    project: Project
}
