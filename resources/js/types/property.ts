import type { PropertyStatus } from "./propertyStatus";

export interface Property {
    id: number;
    title: string;
    slug: string;
    description: string;
    property_type_id: number;
    property_type: {
        id: number;
        name: string;
        code: string;
    };
    operations: Array<{
        id?: number;
        operation_type_id: number;
        price: number;
        currency: string;
        status: string | PropertyStatus;
        name: string;
        operation_type?: {
            id: number;
            name: string;
            code: string;
        };
    }>;
    images?: string;
    created_at: string;
    updated_at: string;
}
