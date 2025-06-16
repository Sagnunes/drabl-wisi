export interface Fund {
    id: number;
    name: string;
    acronym: string;
}

export interface DigitalObject {
    id: number ;
    title: string;
    image_name: string;
    image_thumb: string;
    image_derivative: string;
    fund_acronym: string;
    inventory_number: string;
    website_link: string;
    status: number;
}

export interface FundWithDigitalObject extends Fund{
    digital_objects: Pick<DigitalObject, 'image_thumb' | 'image_name' | 'id'>[];
}
