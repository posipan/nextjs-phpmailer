'use client';

import axios from 'axios';
import { useState } from 'react';
import { useForm, SubmitHandler } from 'react-hook-form';
import { useRouter } from 'next/navigation';
import styles from './Contact.module.css';

type FormDataTypes = {
  name: string;
  email: string;
  content: string;
};

const Contact = () => {
  const router = useRouter();

  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<FormDataTypes>({
    // defaultValues: {
    //   name: 'テスト太郎',
    //   email: 'example@example.com',
    //   content: 'asdf',
    // },
  });

  const [isLoading, setIsLoading] = useState<boolean>(false);

  const onSubmit: SubmitHandler<FormDataTypes> = async (
    data: FormDataTypes
  ) => {
    setIsLoading(true);

    try {
      const response = await axios.post(
        process.env.NEXT_PUBLIC_FETCH_CONTACT_URL as string,
        data,
        {
          headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
          },
        }
      );

      const isSuccess: boolean = response.data.success;
      setIsLoading(false);

      if (isSuccess) {
        router.push('/thanks/');
      } else {
        console.log('送信に失敗しました。');
      }
    } catch (error) {
      setIsLoading(false);
      console.error(error);
    }
  };

  return (
    <form
      onSubmit={handleSubmit(onSubmit)}
      className={styles.contactForm}
    >
      <div className={styles.contactForm__item}>
        <label htmlFor="name" className={styles.contactForm__item__label}>
          お名前
        </label>
        <div className={styles.contactForm__item__body}>
          <input
            type="text"
            {...register('name', {
              required: 'お名前を入力してください',
              maxLength: {
                value: 30,
                message: '30文字以下で入力してください',
              },
            })}
            className={styles.contactForm__item__input}
            placeholder="山田 太郎"
          />
          {errors.name?.message && (
            <p className={styles.contactForm__error}>{errors.name?.message}</p>
          )}
        </div>
      </div>
      <div className={styles.contactForm__item}>
        <label htmlFor="email" className={styles.contactForm__item__label}>
          メールアドレス
        </label>
        <div className={styles.contactForm__item__body}>
          <input
            type="email"
            {...register('email', {
              required: 'メールアドレスを入力してください',
              maxLength: {
                value: 255,
                message: '255文字以下で入力してください',
              },
              pattern: {
                value:
                  /^[a-zA-Z0-9_.+-]+@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/,
                message: 'メールアドレス形式で入力してください',
              },
            })}
            className={styles.contactForm__item__input}
            placeholder="example@example.com"
          />
          {errors.email?.message && (
            <p className={styles.contactForm__error}>{errors.email?.message}</p>
          )}
        </div>
      </div>
      <div className={styles.contactForm__item}>
        <label htmlFor="content" className={styles.contactForm__item__label}>
          お問い合わせ内容
        </label>
        <div className={styles.contactForm__item__body}>
          <textarea
            {...register('content', {
              required: 'お問い合わせ内容を入力してください',
              maxLength: {
                value: 1000,
                message: '1000文字以下の数字で入力してください',
              },
            })}
            className={styles.contactForm__item__textarea}
            rows={10}
          />
          {errors.content?.message && (
            <p className={styles.contactForm__error}>
              {errors.content?.message}
            </p>
          )}
        </div>
      </div>
      <button type="submit" className={styles.contactForm__btn}>
        {isLoading ? '送信中...' : '送信する'}
      </button>
    </form>
  );
};

export default Contact;
