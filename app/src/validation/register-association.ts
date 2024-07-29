import { z } from "zod"

/*
create zod schema for register association
[{"key":"manager_name","value":"Ahmed Salama","type":"text","enabled":true},{"key":"phone_number","value":"0547869731","type":"text","enabled":true},{"key":"email","value":"ahmedyassersalama2011@gmail.com","type":"text","enabled":true},{"key":"password","value":"20111994","type":"text","enabled":true},{"key":"password_confirmation","value":"20111994","type":"text","enabled":true},{"key":"national_id","value":"98888555","description":"","type":"text","enabled":true},{"key":"association_name","value":"جمعية الدرة","type":"text","enabled":true},{"key":"address","value":"15th elola street, dawaran, florida","type":"text","enabled":true},{"key":"map_link","value":"https://www.google.com/maps/place/24%C2%B052'23.9%22N+46%C2%B038'34.0%22E/@24.873308,46.64277,17z/data=!3m1!4b1!4m4!3m3!8m2!3d24.873308!4d46.64277?entry=ttu","type":"text","enabled":true},{"key":"registration_number","value":"898985554","description":"","type":"text","enabled":true},{"key":"subscription_period","value":"3","description":"amount of months","type":"text","enabled":true}]
*/
export const RegisterAssociationSchema = z
  .object({
    manager_name: z.string().min(1, "حقل مطلوب"),
    phone_number: z
      .string()
      .min(1, "حقل مطلوب")
      .regex(/^\s*\d+\s*$/, "رقم غير صالح"),
    email: z.string().email("الرجاء استخدام ايميل صالح"),
    password: z.string().min(8, "كلمة مرور قصيرة جدا"),
    password_confirmation: z.string(),
    national_id: z
      .string()
      .min(1, "حقل مطلوب")
      .regex(/^\s*\d+\s*$/, "رقم غير صالح"),
    association_name: z.string().min(1, "حقل مطلوب"),
    address: z.string().min(1, "حقل مطلوب"),
    map_link: z.string().url("رابط غير صالح"),
    registration_number: z.string().min(1, "حقل مطلوب"),
    subscription_period: z.enum(["1", "3", "6", "12"]),
  })
  .refine(
    (obj) => {
      return obj.password === obj.password_confirmation
    },
    {
      message: "كلمتا المرور غير متطابقتان",
      path: ["password_confirmation"],
    },
  )
