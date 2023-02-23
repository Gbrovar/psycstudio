export class User{
    constructor(
        public id: number,
        public name: string,
        public surname: string,
        public email: string,
        public phone_number: string, 
        public country: string,
        public address: string,
        public password: string,
        public gender: string,
        public birthday: string,
        public description: string,
        public therapist_id: number,
        public role: string,
        public image: string
    ){}
}