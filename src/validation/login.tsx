import { z } from "zod"

export const phoneNumberSchema = z
  .string()
  .regex(/^\+?(966)?5\d{8}$/, "الرجاء استخدام رقم سعودي")
  .refine(
    (number) => {
      if (
        (number.length === 9 && number.startsWith("966")) ||
        (number.startsWith("+966") && number.length === 10)
      ) {
        return false
      }
      return true
    },
    {
      message: "الرجاء استخدام رقم سعودي",
    },
  )
const LoginSchema = z
  .object({
    username: z.string().min(1, "حقل مطلوب"),
    password: z.string().min(8, "كلمة المرورو غير صالحة"),
  })
  .refine(
    (schemaObj) => {
      if (parseInt(schemaObj.username)) {
        return phoneNumberSchema.safeParse(schemaObj.username).success
      }
      return true
    },
    {
      message: "الرجاء استخدام رقم سعودي",
      path: ["username"],
    },
  )
  .refine(
    (schemaObj) => {
      if (!parseInt(schemaObj.username)) {
        return z.string().email().safeParse(schemaObj.username).success
      }
      return true
    },
    {
      message: "إيميل غير صحيح",
      path: ["username"],
    },
  )
export { LoginSchema }
